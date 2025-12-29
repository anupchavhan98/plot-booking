<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Plot;
use App\Models\Agent;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::whereHas('booking', fn($q) => $q->where('status', 'approved'))
                              ->sum('amount');

        $monthlyBookings = Booking::whereMonth('booking_date', now()->month)
                                  ->whereYear('booking_date', now()->year)
                                  ->count();

        $totalAgents = Agent::count();

        $totalCommission = \App\Models\Commission::sum('commission_amount');

        $availablePlots = Plot::available()->count();
        $bookedPlots = Plot::booked()->count();
        $blockedPlots = Plot::blocked()->count();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'monthlyBookings',
            'totalAgents',
            'totalCommission',
            'availablePlots',
            'bookedPlots',
            'blockedPlots'
        ));
    }
}