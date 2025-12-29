<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plot_number',
        'size',
        'price',
        'location',
        'description',
        'status',
        'row_position',
        'col_position',
    ];

    /**
     * Get the booking for this plot (if booked).
     */
    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    /**
     * Scope for available plots.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope for booked plots.
     */
    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }

    /**
     * Scope for blocked plots.
     */
    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }
}