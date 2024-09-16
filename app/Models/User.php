<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_suspended',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_suspended' => 'boolean',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function setRole($role)
    {
        $this->update(['role' => $role]);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function suspend()
    {
        $this->update(['is_suspended' => true]);
    }

    public function unsuspend()
    {
        $this->update(['is_suspended' => false]);
    }

    public function toggleSuspension()
    {
        $this->update(['is_suspended' => !$this->is_suspended]);
    }

    public function isSuspended()
    {
        return $this->is_suspended;
    }

    public function getStatusAttribute()
    {
        return $this->is_suspended ? 'Suspended' : 'Active';
    }
}
