<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'agent_id',
        'commission_amount',
        'paid',
        'paid_date',
    ];

    /**
     * Get the booking this commission is for.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the agent who earned this commission.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}