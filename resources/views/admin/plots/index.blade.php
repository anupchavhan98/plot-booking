@extends('admin.layout')

@section('title', 'Plot Management')

@section('page-title', 'Plot Management')

@section('content')
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Plots</h5>
            <a href="{{ route('admin.plots.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Plot
            </a>
        </div>
        <div class="card-body">
            <!-- Search -->
            <div class="mb-3">
                <input type="text" id="search" class="form-control w-25" placeholder="Search by plot number or location...">
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="plots-table">
                    <thead class="table-light">
                        <tr>
                            <th>Plot Number</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plots as $plot)
                            <tr data-plot-id="{{ $plot->id }}">
                                <td><strong>{{ $plot->plot_number }}</strong></td>
                                <td>{{ number_format($plot->size, 2) }} sq.ft</td>
                                <td>₹{{ number_format($plot->price, 2) }}</td>
                                <td>{{ $plot->location ?? '-' }}</td>
                                <td>
                                    <select class="form-select form-select-sm status-select" data-id="{{ $plot->id }}">
                                        <option value="available" {{ $plot->status == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="booked" {{ $plot->status == 'booked' ? 'selected' : '' }}>Booked</option>
                                        <option value="blocked" {{ $plot->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="{{ route('admin.plots.edit', $plot) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-plot" data-id="{{ $plot->id }}"
                                        {{ $plot->status == 'booked' ? 'disabled' : '' }}>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $plots->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 for nice confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete Plot
        document.querySelectorAll('.delete-plot').forEach(button => {
            button.addEventListener('click', function () {
                const plotId = this.dataset.id;
                const plotName = this.dataset.name || 'this plot';

                if (this.disabled) {
                    toastr.warning('Cannot delete a booked plot!');
                    return;
                }

                Swal.fire({
                    title: 'Delete Plot?',
                    text: `Are you sure you want to delete plot "${plotName}"? This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/plots/${plotId}`, {   // ← CORRECT URL WITH ID
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                const row = this.closest('tr');
                                row.style.transition = 'opacity 0.6s';
                                row.style.opacity = '0';
                                setTimeout(() => row.remove(), 600);
                                toastr.success('Plot deleted successfully!');
                            } else {
                                response.json().then(err => {
                                    toastr.error(err.message || 'Delete failed');
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('Network error or server issue');
                        });
                    }
                });
            });
        });
    });
</script>
@endsection