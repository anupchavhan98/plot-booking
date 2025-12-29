@extends('admin.layout')

@section('title', 'Bookings')

@section('page-title', 'Booking Management')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h5>All Bookings</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Plot</th>
                            <th>Customer</th>
                            <th>Agent</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->plot->plot_number }}</td>
                                <td>{{ $booking->customer->name }}</td>
                                <td>{{ $booking->agent?->name ?? '-' }}</td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $bookings->links() }}
        </div>
    </div>
@endsection