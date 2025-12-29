@extends('admin.layout')

@section('title', 'Edit Plot')

@section('page-title', 'Edit Plot: ' . $plot->plot_number)

@section('content')
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Plot</h5>
            <a href="{{ route('admin.plots.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.plots.update', $plot) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Plot Number <span class="text-danger">*</span></label>
                        <input type="text" name="plot_number" class="form-control @error('plot_number') is-invalid @enderror"
                               value="{{ old('plot_number', $plot->plot_number) }}" required>
                        @error('plot_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Size (sq.ft) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="size" class="form-control @error('size') is-invalid @enderror"
                               value="{{ old('size', $plot->size) }}" required>
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $plot->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                               value="{{ old('location', $plot->location) }}">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $plot->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status', $plot->status) == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="booked" {{ old('status', $plot->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="blocked" {{ old('status', $plot->status) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Row Position (for layout)</label>
                        <input type="number" name="row_position" class="form-control"
                               value="{{ old('row_position', $plot->row_position) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Column Position (for layout)</label>
                        <input type="number" name="col_position" class="form-control"
                               value="{{ old('col_position', $plot->col_position) }}">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-save me-2"></i> Update Plot
                    </button>
                    <a href="{{ route('admin.plots.index') }}" class="btn btn-secondary btn-lg px-5 ms-3">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection