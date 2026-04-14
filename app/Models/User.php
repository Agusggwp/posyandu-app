<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getRoleNameAttribute(): ?string
    {
        if ($this->relationLoaded('role') && $this->getRelation('role')) {
            return strtolower((string) $this->getRelation('role')->name);
        }

        if (!empty($this->role_id)) {
            $role = $this->role()->select('name')->first();
            if ($role) {
                return strtolower((string) $role->name);
            }
        }

        $rawRole = $this->attributes['role'] ?? null;
        return $rawRole ? strtolower((string) $rawRole) : null;
    }

    protected function resolvedRole(): ?Role
    {
        if ($this->relationLoaded('role') && $this->getRelation('role')) {
            return $this->getRelation('role');
        }

        if (!empty($this->role_id)) {
            return $this->role()->first();
        }

        return null;
    }

    public function pemeriksaanBalitas()
    {
        return $this->hasMany(PemeriksaanBalita::class);
    }

    public function pemeriksaanIbuHamils()
    {
        return $this->hasMany(PemeriksaanIbuHamil::class);
    }

    public function pemeriksaanLansias()
    {
        return $this->hasMany(PemeriksaanLansia::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role_name === 'admin';
    }

    /**
     * Check if user is kader
     */
    public function isKader()
    {
        return $this->role_name === 'kader';
    }

    /**
     * Check if user is bidan
     */
    public function isBidan()
    {
        return $this->role_name === 'bidan';
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission($permission)
    {
        $role = $this->resolvedRole();
        return $role ? $role->hasPermission($permission) : false;
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission($permissions)
    {
        if (!$this->resolvedRole()) {
            return false;
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has all of the given permissions
     */
    public function hasAllPermissions($permissions)
    {
        if (!$this->resolvedRole()) {
            return false;
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }
}
