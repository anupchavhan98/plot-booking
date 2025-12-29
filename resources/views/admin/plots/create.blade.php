@extends('admin.layout')

@section('title', 'Add New Plot')

@section('page-title', 'Add New Plot')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h5>Add New Plot</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.plots.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Plot Number <span class="text-danger">*</span></label>
                        <input type="text" name="plot_number" class="form-control" value="{{ old('plot_number') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Size (sq.ft) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="size" class="form-control" value="{{ old('size') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Price (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                    </div>
                    <div class="col-12">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                            <option value="blocked">Blocked</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Row Position (for layout)</label>
                        <input type="number" name="row_position" class="form-control" value="{{ old('row_position') }}">
                    </div>
                    <div class="col-md-4">
                        <label>Column Position (for layout)</label>
                        <input type="number" name="col_position" class="form-control" value="{{ old('col_position') }}">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Plot</button>
                    <a href="{{ route('admin.plots.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection