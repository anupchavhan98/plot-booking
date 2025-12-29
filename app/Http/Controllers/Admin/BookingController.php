<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Plot;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['plot', 'customer', 'agent'])
                           ->orderByDesc('created_at')
                           ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $booking->status = $request->status;

        if ($request->status === 'approved') {
            $booking->plot->status = 'booked';
            $booking->plot->save();
        } elseif ($request->status === 'rejected') {
            $booking->plot->status = 'available';
            $booking->plot->save();
        }

        $booking->save();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking status updated!');
    }
}