@extends('layouts.user')

@section('title', 'Agent Dashboard')

@section('page-title', 'Welcome, ' . Auth::user()->name)

@section('content')
    <div class="row g-4 mb-5">
        <div class="col-md-4 col-sm-6">
            <div class="card text-white bg-primary shadow">
                <div class="card-body text-center">
                    <i class="fas fa-briefcase fa-3x mb-3"></i>
                    <h3>{{ Auth::user()->agent->bookings->count() }}</h3>
                    <p class="mb-0">My Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <i class="fas fa-rupee-sign fa-3x mb-3"></i>
                    <h3>₹{{ number_format(Auth::user()->agent->total_earnings ?? 0, 2) }}</h3>
                    <p class="mb-0">Total Earnings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card text-white bg-info shadow">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h3>{{ Auth::user()->agent->bookings->where('status', 'approved')->count() }}</h3>
                    <p class="mb-0">Approved Deals</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h5>My Recent Bookings</h5>
            <a href="{{ route('agent.bookings') }}" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Plot</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->agent->bookings->take(6) as $booking)
                            <tr>
                                <td>#BK{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $booking->plot->plot_number }}</td>
                                <td>{{ $booking->customer->name }}</td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No bookings yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection