@extends('admin.layout')

@section('title', 'Reports')

@section('page-title', 'Reports & Analytics')

@section('content')
    <div class="row g-4 mb-5">
        <!-- Dynamic Summary Cards -->
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>₹{{ number_format($totalRevenue, 2) }}</h4>
                            <p class="mb-0">Total Revenue</p>
                        </div>
                        <i class="fas fa-rupee-sign fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{ $monthlyBookings }}</h4>
                            <p class="mb-0">Bookings This Month</p>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{ $totalAgents }}</h4>
                            <p class="mb-0">Active Agents</p>
                        </div>
                        <i class="fas fa-user-tie fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>₹{{ number_format($totalCommission, 2) }}</h4>
                            <p class="mb-0">Total Agent Commission</p>
                        </div>
                        <i class="fas fa-handshake fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5>Plot Status Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-4">
                            <h3 class="text-success">{{ $availablePlots }}</h3>
                            <p class="mb-0">Available Plots</p>
                        </div>
                        <div class="col-md-4 mb-4">
                            <h3 class="text-danger">{{ $bookedPlots }}</h3>
                            <p class="mb-0">Booked Plots</p>
                        </div>
                        <div class="col-md-4 mb-4">
                            <h3 class="text-secondary">{{ $blockedPlots }}</h3>
                            <p class="mb-0">Blocked Plots</p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mt-4">Recent Reports</h6>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Monthly Revenue Report - December 2025</h6>
                                <small>Generated 2 hours ago</small>
                            </div>
                            <small>Total: ₹{{ number_format($totalRevenue, 2) }}</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Agent Commission Summary</h6>
                                <small>Generated yesterday</small>
                            </div>
                            <small>Paid: ₹{{ number_format($paidCommission ?? 0, 2) }}</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection