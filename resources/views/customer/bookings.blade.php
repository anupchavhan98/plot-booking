@extends('layouts.user')

@section('title', 'My Bookings')

@section('page-title', 'My Bookings')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h5>All My Bookings ({{ Auth::user()->bookings->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Plot Number</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Booking Date</th>
                            <th>Token Amount</th>
                            <th>Status</th>
                            <th>Payments Made</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->bookings as $booking)
                            <tr>
                                <td>#BK{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td><strong>{{ $booking->plot->plot_number }}</strong></td>
                                <td>{{ number_format($booking->plot->size, 2) }} sq.ft</td>
                                <td>₹{{ number_format($booking->plot->price, 2) }}</td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                <td>₹{{ number_format($booking->booking_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($booking->payments->sum('amount'), 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No bookings found. <a href="{{ route('public.plots') }}">Browse plots now</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection