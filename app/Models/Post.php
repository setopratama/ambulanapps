<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'start_point',
        'end_point',
        'is_suspended',
    ];

    protected $casts = [
        'is_suspended' => 'boolean',
        'start_point' => 'json',
        'end_point' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
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

    public function scopeActive($query)
    {
        return $query->where('is_suspended', false);
    }

    public function scopeSuspended($query)
    {
        return $query->where('is_suspended', true);
    }
}
