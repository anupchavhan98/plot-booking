@extends('admin.layout')

@section('title', 'Add New Agent')

@section('page-title', 'Add New Agent')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h5>Create Agent Account</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.agents.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Commission Percentage</label>
                        <input type="number" step="0.01" name="commission_percentage" class="form-control" value="{{ old('commission_percentage', 5) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create Agent</button>
                    <a href="{{ route('admin.agents.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection