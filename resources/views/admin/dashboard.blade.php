@extends('admin.layout')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card text-primary">
                <i class="fas fa-th-large"></i>
                <h3>{{ $totalPlots }}</h3>
                <p class="mb-0 text-muted">Total Plots</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card text-success">
                <i class="fas fa-check-circle"></i>
                <h3>{{ $availablePlots }}</h3>
                <p class="mb-0 text-muted">Available Plots</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card text-danger">
                <i class="fas fa-home"></i>
                <h3>{{ $bookedPlots }}</h3>
                <p class="mb-0 text-muted">Booked Plots</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card text-warning">
                <i class="fas fa-ban"></i>
                <h3>{{ $blockedPlots }}</h3>
                <p class="mb-0 text-muted">Blocked Plots</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-4 col-sm-6">
            <div class="stat-card text-info">
                <i class="fas fa-users"></i>
                <h3>{{ $totalCustomers }}</h3>
                <p class="mb-0 text-muted">Total Customers</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="stat-card text-primary">
                <i class="fas fa-user-tie"></i>
                <h3>{{ $totalAgents }}</h3>
                <p class="mb-0 text-muted">Total Agents</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="stat-card text-success">
                <i class="fas fa-rupee-sign"></i>
                <h3>₹{{ number_format($totalRevenue, 2) }}</h3>
                <p class="mb-0 text-muted">Total Revenue</p>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h5>Recent Activity</h5>
        <div class="card">
            <div class="card-body">
                <p class="text-muted">Activity log coming soon...</p>
            </div>
        </div>
    </div>
@endsection