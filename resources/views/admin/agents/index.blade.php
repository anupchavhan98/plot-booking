@extends('admin.layout')

@section('title', 'Agents')

@section('page-title', 'Agent Management')

@section('content')
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h5>All Agents</h5>
            <a href="{{ route('admin.agents.create') }}" class="btn btn-primary">Add Agent</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Commission %</th>
                            <th>Total Earnings</th>
                            <th>Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agents as $agent)
                            <tr>
                                <td>{{ $agent->name }}</td>
                                <td>{{ $agent->email }}</td>
                                <td>{{ $agent->phone ?? '-' }}</td>
                                <td>{{ $agent->agent->commission_percentage }}%</td>
                                <td>₹{{ number_format($agent->agent->total_earnings, 2) }}</td>
                                <td>{{ $agent->agent->bookings->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $agents->links() }}
        </div>
    </div>
@endsection