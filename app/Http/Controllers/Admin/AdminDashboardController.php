<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plot;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Agent;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with key statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Total Plots
        $totalPlots = Plot::count();

        // Plots by status
        $availablePlots = Plot::available()->count();
        $bookedPlots = Plot::booked()->count();
        $blockedPlots = Plot::blocked()->count();

        // Users
        $totalCustomers = User::whereHas('role', function ($query) {
            $query->where('slug', 'customer');
        })->count();

        $totalAgents = User::whereHas('role', function ($query) {
            $query->where('slug', 'agent');
        })->count();

        // Total Revenue from approved bookings and paid payments
        $totalRevenue = Payment::whereHas('booking', function ($query) {
            $query->where('status', 'approved');
        })->sum('amount');

        return view('admin.dashboard', compact(
            'totalPlots',
            'availablePlots',
            'bookedPlots',
            'blockedPlots',
            'totalCustomers',
            'totalAgents',
            'totalRevenue'
        ));
    }
}