<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'is_active',
        'last_login_at',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'permissions' => 'array',
        'is_active' => 'boolean',
    ];

    public function hasPermission($permission)
    {
        if ($this->role === 'super_admin') {
            return true;
        }
        
        return in_array($permission, $this->permissions ?? []);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}