<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];
    protected $table = 'settings';

    /**
     * Get a setting value by key
     */
    public static function getSetting(string $key, mixed $default = null): mixed
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        // Cast value based on type
        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int)$setting->value,
            'array', 'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    /**
     * Set a setting value
     */
    public static function setSetting(string $key, mixed $value, string $type = 'string'): self
    {
        // Convert value to string for storage
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
            $type = 'json';
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
            $type = 'boolean';
        } elseif (is_numeric($value) && !is_string($value)) {
            $value = (string)$value;
            $type = 'integer';
        }

        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Get all settings as key => value array
     */
    public static function getAllSettings(): array
    {
        return self::all()->mapWithKeys(function ($setting) {
            return [$setting->key => self::getSetting($setting->key)];
        })->toArray();
    }
}
