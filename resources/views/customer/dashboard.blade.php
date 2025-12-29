@extends('layouts.user')

@section('title', 'Customer Dashboard')

@section('page-title', 'Welcome back, ' . Auth::user()->name)

@section('content')
    <div class="row g-4 mb-5">
        <div class="col-md-4 col-sm-6">
            <div class="card text-white bg-primary shadow">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x mb-3"></i>
                    <h3>{{ Auth::user()->bookings->count() }}</h3>
                    <p class="mb-0">Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h3>{{ Auth::user()->bookings->where('status', 'approved')->count() }}</h3>
                    <p class="mb-0">Approved Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card text-white bg-warning shadow">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-3x mb-3"></i>
                    <h3>{{ Auth::user()->bookings->where('status', 'pending')->count() }}</h3>
                    <p class="mb-0">Pending Approval</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>My Recent Bookings</h5>
            <a href="{{ route('customer.bookings') }}" class="btn btn-sm btn-primary">View All Bookings</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Plot</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->bookings->sortByDesc('created_at')->take(6) as $booking)
                            <tr>
                                <td>#BK{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td><strong>{{ $booking->plot->plot_number }}</strong></td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                <td>₹{{ number_format($booking->booking_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    You have no bookings yet. <a href="{{ route('public.plots') }}">Browse available plots</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection