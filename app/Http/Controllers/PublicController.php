<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function plots()
    {
        $plots = Plot::orderBy('plot_number')->get();
        return view('public.plots', compact('plots'));
    }

    public function bookPlot(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book a plot.');
        }

        $request->validate([
            'plot_id' => 'required|exists:plots,id',
            'booking_amount' => 'required|numeric|min:0',
        ]);

        $plot = Plot::findOrFail($request->plot_id);

        if ($plot->status !== 'available') {
            return back()->with('error', 'This plot is no longer available.');
        }

        Booking::create([
            'plot_id' => $plot->id,
            'customer_id' => Auth::id(),
            'agent_id' => null,
            'booking_amount' => $request->booking_amount,
            'booking_date' => now(),
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('public.plots')->with('success', 'Booking request submitted! Admin will review it soon.');
    }
}