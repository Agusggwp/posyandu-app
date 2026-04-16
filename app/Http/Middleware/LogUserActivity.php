<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
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

        $description = sprintf(
            '%s %s (%s)',
            ucfirst($action),
            $route->uri(),
            $controllerMethod
        );

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'model' => $resource,
                'description' => $description,
                'properties' => [
                    'route_name' => $route->getName(),
                    'route_uri' => $route->uri(),
                    'method' => $method,
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
}
