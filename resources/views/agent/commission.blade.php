@extends('layouts.user')

@section('title', 'My Commission')

@section('page-title', 'Commission Earnings')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <h3>₹{{ number_format(Auth::user()->agent->total_earnings ?? 0, 2) }}</h3>
                    <p>Total Earnings</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-warning shadow">
                <div class="card-body text-center">
                    <h3>{{ Auth::user()->agent->commissions->where('paid', true)->count() }}</h3>
                    <p>Paid Commissions</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h5>Commission History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Plot</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->agent->commissions as $commission)
                            <tr>
                                <td>#BK{{ str_pad($commission->booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $commission->booking->plot->plot_number }}</td>
                                <td>₹{{ number_format($commission->commission_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $commission->paid ? 'success' : 'secondary' }}">
                                        {{ $commission->paid ? 'Paid' : 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $commission->paid_date ? $commission->paid_date->format('d M Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No commissions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection