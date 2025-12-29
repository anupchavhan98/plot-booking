@extends('layouts.user')

@section('title', 'My Bookings')

@section('page-title', 'My Bookings')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h5>All My Bookings ({{ Auth::user()->agent->bookings->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Plot</th>
                            <th>Customer</th>
                            <th>Booking Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->agent->bookings as $booking)
                            <tr>
                                <td>#BK{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td><strong>{{ $booking->plot->plot_number }}</strong></td>
                                <td>{{ $booking->customer->name }}</td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                <td>₹{{ number_format($booking->booking_amount ?? $booking->plot->price * 0.1, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->commission)
                                        ₹{{ number_format($booking->commission->commission_amount, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No bookings handled yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection