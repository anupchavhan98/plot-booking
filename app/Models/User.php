<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the role that the user belongs to.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the agent record if the user is an agent.
     */
    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    /**
     * Get all bookings made by the user (as customer).
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    /**
     * Check if user has a specific role.
     *
     * @param string $slug
     * @return bool
     */
    public function hasRole($slug)
    {
        return $this->role && $this->role->slug === $slug;
    }

    /**
     * Scope to get only active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}