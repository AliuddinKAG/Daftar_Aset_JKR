<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Check if user is admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Check if user is active
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Relationships
    public function components()
    {
        return $this->hasMany(\App\Models\Component::class);
    }

    public function mainComponents()
    {
        return $this->hasMany(\App\Models\MainComponent::class);
    }

    public function subComponents()
    {
        return $this->hasMany(\App\Models\SubComponent::class);
    }
}