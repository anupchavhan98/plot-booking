@extends('layouts.user')

@section('title', 'Agent Dashboard')

@section('page-title', 'Agent Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h4>{{ Auth::user()->agent->bookings->count() }}</h4>
                    <p>My Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h4>₹{{ number_format(Auth::user()->agent->total_earnings, 2) }}</h4>
                    <p>Total Earnings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h4>{{ Auth::user()->agent->bookings->where('status', 'approved')->count() }}</h4>
                    <p>Approved Deals</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4 shadow">
        <div class="card-header">
            <h5>My Recent Bookings</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('agent.bookings') }}" class="btn btn-primary mb-3">View All</a>
            <!-- Similar table as customer -->
        </div>
    </div>
@endsection