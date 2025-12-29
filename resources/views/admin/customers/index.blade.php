@extends('admin.layout')

@section('title', 'Customers')

@section('page-title', 'Customer Management')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h5>All Customers</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Bookings</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td>{{ $customer->bookings->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $customers->links() }}
        </div>
    </div>
@endsection