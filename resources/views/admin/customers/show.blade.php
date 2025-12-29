@extends('admin.layout')

@section('title', 'Customer: ' . $customer->name)

@section('page-title', 'Customer Details: ' . $customer->name)

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5>Customer Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $customer->name }}</p>
                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                    <p><strong>Phone:</strong> {{ $customer->phone ?? '-' }}</p>
                    <p><strong>Joined:</strong> {{ $customer->created_at->format('d M Y') }}</p>
                    <p><strong>Total Bookings:</strong> {{ $customer->bookings->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5>Booking History</h5>
                </div>
                <div class="card-body">
                    @if($customer->bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Plot</th>
                                        <th>Booking Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->plot->plot_number }}</td>
                                            <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                            <td>₹{{ number_format($booking->booking_amount ?? 0, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>₹{{ number_format($booking->payments->sum('amount'), 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No bookings yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection