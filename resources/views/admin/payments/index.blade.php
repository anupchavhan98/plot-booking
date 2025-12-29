@extends('admin.layout')

@section('title', 'Payments')

@section('page-title', 'Payment Records')

@section('content')
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Payment Records ({{ $payments->total() }})</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                <i class="fas fa-plus me-1"></i> Record Payment
            </button>
        </div>
        <div class="card-body">
            <!-- Search & Filters -->
            <form method="GET" action="{{ route('admin.payments.index') }}" class="row mb-4 g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search transaction ID, customer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="method" class="form-select">
                        <option value="">All Methods</option>
                        @foreach(['Cash', 'Bank Transfer', 'UPI', 'Cheque', 'Online'] as $method)
                            <option value="{{ strtolower(str_replace(' ', '_', $method)) }}"
                                {{ request('method') == strtolower(str_replace(' ', '_', $method)) ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Payment ID</th>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Plot</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>#PAY{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>#BK{{ str_pad($payment->booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $payment->booking->customer->name }}</td>
                                <td>{{ $payment->booking->plot->plot_number }}</td>
                                <td>₹{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    <span class="text-capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</span>
                                </td>
                                <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No payment records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $payments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection