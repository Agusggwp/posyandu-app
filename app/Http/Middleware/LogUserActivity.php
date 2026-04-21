<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! auth()->check()) {
            return $response;
        }

        $route = $request->route();
        if (! $route) {
            return $response;
        }

        $controllerClass = $route->getControllerClass();
        $controllerMethod = $route->getActionMethod();

        // Login/logout are already logged via auth events.
        if (in_array($controllerMethod, ['login', 'logout'], true)) {
            return $response;
        }

        // Keep manual detailed logs for these actions to avoid duplicates.
        if (
            in_array($controllerClass, [
                \App\Http\Controllers\Admin\UserController::class,
                \App\Http\Controllers\Admin\RoleController::class,
            ], true)
            && in_array($controllerMethod, ['store', 'update', 'destroy'], true)
        ) {
            return $response;
        }

        $method = strtoupper($request->method());

        $action = match ($method) {
            'POST' => 'created',
            'PUT', 'PATCH' => 'updated',
            'DELETE' => 'deleted',
            'GET' => 'viewed',
            default => strtolower($method),
        };

        // Skip logging view actions - only log crucial actions (create, update, delete)
        if ($action === 'viewed') {
            return $response;
        }

        $resource = $this->guessResourceName($controllerClass);
        [$modelId, $targetLabel] = $this->extractTarget($route?->parameters() ?? []);
        $sanitizedInput = $this->sanitizeInput($request->all());
        $changedFields = array_keys($sanitizedInput);

        $description = $this->buildDescription(
            $action,
            $resource,
            $controllerMethod,
            $targetLabel,
            $changedFields,
            $response->getStatusCode()
        );

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'model' => $resource,
                'model_id' => $modelId,
                'description' => $description,
                'properties' => [
                    'route_name' => $route->getName(),
                    'route_uri' => $route->uri(),
                    'method' => $method,
                    'controller' => $controllerClass,
                    'controller_method' => $controllerMethod,
                    'target_label' => $targetLabel,
                    'changed_fields' => $changedFields,
                    'input_preview' => $this->previewInput($sanitizedInput),
                    'status_code' => $response->getStatusCode(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Never block the request flow if logging fails.
        }

        return $response;
    }

    private function guessResourceName(?string $controllerClass): string
    {
        if (! $controllerClass) {
            return 'Route';
        }

        $baseName = class_basename($controllerClass);

        return str_ends_with($baseName, 'Controller')
            ? substr($baseName, 0, -10)
            : $baseName;
    }

    private function buildDescription(
        string $action,
        string $resource,
        string $controllerMethod,
        ?string $targetLabel,
        array $changedFields,
        int $statusCode
    ): string {
        $actionLabel = match ($action) {
            'created' => 'Membuat',
            'updated' => 'Mengubah',
            'deleted' => 'Menghapus',
            default => ucfirst($action),
        };

        $base = $actionLabel . ' ' . $resource;

        if ($targetLabel) {
            $base .= ' [' . $targetLabel . ']';
        }

        if (! empty($changedFields) && in_array($action, ['created', 'updated'], true)) {
            $base .= ' | Field: ' . implode(', ', $changedFields);
        }

        $base .= ' | Method: ' . $controllerMethod . ' | Status: ' . $statusCode;

        return $base;
    }

    private function sanitizeInput(array $input): array
    {
        $sensitive = [
            '_token',
            '_method',
            'password',
            'password_confirmation',
            'current_password',
            'new_password',
            'remember_token',
            'remember',
        ];

        $filtered = array_diff_key($input, array_flip($sensitive));

        foreach ($filtered as $key => $value) {
            if (is_string($value)) {
                $filtered[$key] = trim($value);
            }
        }

        return $filtered;
    }

    private function previewInput(array $input): array
    {
        $preview = [];
        $limited = array_slice($input, 0, 8, true);

        foreach ($limited as $key => $value) {
            if (is_array($value)) {
                $preview[$key] = '[array:' . count($value) . ']';
                continue;
            }

            if (is_bool($value)) {
                $preview[$key] = $value ? 'true' : 'false';
                continue;
            }

            if ($value === null || $value === '') {
                $preview[$key] = '-';
                continue;
            }

            $preview[$key] = Str::limit((string) $value, 60);
        }

        return $preview;
    }

    private function extractTarget(array $routeParameters): array
    {
        foreach ($routeParameters as $value) {
            if (is_object($value) && method_exists($value, 'getKey')) {
                $id = $value->getKey();
                $label = class_basename($value) . '#' . $id;

                return [$id, $label];
            }

            if (is_scalar($value) && $value !== '') {
                return [is_numeric($value) ? (int) $value : null, (string) $value];
            }
        }

        return [null, null];
    }
}
