@extends('layouts.user')

@section('title', 'Customer Dashboard')

@section('page-title', 'Welcome back, ' . Auth::user()->name)

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h4>{{ Auth::user()->bookings->count() }}</h4>
                    <p>Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h4>{{ Auth::user()->bookings->where('status', 'approved')->count() }}</h4>
                    <p>Approved Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h4>{{ Auth::user()->bookings->where('status', 'pending')->count() }}</h4>
                    <p>Pending Approval</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4 shadow">
        <div class="card-header">
            <h5>My Recent Bookings</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Plot</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(Auth::user()->bookings->take(5) as $booking)
                            <tr>
                                <td>{{ $booking->plot->plot_number }}</td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                <td>₹{{ number_format($booking->booking_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('customer.bookings') }}" class="btn btn-primary">View All Bookings</a>
        </div>
    </div>
@endsection