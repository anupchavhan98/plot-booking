<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'commission_percentage',
        'total_earnings',
    ];

    /**
     * Get the user (agent) that owns this agent record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all bookings handled by this agent.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'agent_id', 'user_id');
    }

    /**
     * Get all commissions earned by this agent.
     */
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}