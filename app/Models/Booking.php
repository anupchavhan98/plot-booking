<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plot_id',
        'customer_id',
        'agent_id',
        'booking_amount',
        'booking_date',
        'status',
        'notes',
    ];

    // ADD THIS LINE (or use $casts below)
    protected $dates = ['booking_date', 'created_at', 'updated_at'];

    protected $casts = [
    'booking_date' => 'date',
    'booking_amount' => 'decimal:2',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

    /**
     * Get the plot that was booked.
     */
    public function plot()
    {
        return $this->belongsTo(Plot::class);
    }

    /**
     * Get the customer who made the booking.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the agent who handled the booking (if any).
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get all payments for this booking.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the commission record for this booking.
     */
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }
}