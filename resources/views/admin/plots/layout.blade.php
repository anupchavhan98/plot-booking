@extends('admin.layout')

@section('title', 'Plot Layout View')

@section('page-title', 'Plot Layout View')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h5>Interactive Plot Layout</h5>
            <small class="text-muted">Click on any plot to view details</small>
        </div>
        <div class="card-body">
            <div class="plot-grid" style="display: grid; grid-template-columns: repeat(10, 1fr); gap: 10px; max-width: 100%;">
                @php
                    $plots = \App\Models\Plot::orderBy('row_position')->orderBy('col_position')->get();
                @endphp

                @foreach($plots as $plot)
                    <div class="plot-box text-center p-3 rounded shadow-sm position-relative"
                         style="background-color:
                            {{ $plot->status == 'available' ? '#d4edda' :
                               ($plot->status == 'booked' ? '#f8d7da' : '#e2e3e5') }};"
                         data-bs-toggle="modal" data-bs-target="#plotModal" data-plot="{{ $plot }}">
                        <strong>{{ $plot->plot_number }}</strong><br>
                        <small>₹{{ number_format($plot->price) }}</small>
                        <span class="badge position-absolute top-0 end-0 m-1
                            {{ $plot->status == 'available' ? 'bg-success' :
                               ($plot->status == 'booked' ? 'bg-danger' : 'bg-secondary') }}">
                            {{ ucfirst($plot->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="plotModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Plot Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="plot-details">
                    <!-- Filled by JS -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.plot-box').forEach(box => {
            box.addEventListener('click', function() {
                let plot = JSON.parse(this.getAttribute('data-plot').replace(/&quot;/g, '"'));
                document.getElementById('plot-details').innerHTML = `
                    <p><strong>Plot Number:</strong> ${plot.plot_number}</p>
                    <p><strong>Size:</strong> ${plot.size} sq.ft</p>
                    <p><strong>Price:</strong> ₹${Number(plot.price).toLocaleString()}</p>
                    <p><strong>Location:</strong> ${plot.location || '-'}</p>
                    <p><strong>Status:</strong> <span class="badge bg-${plot.status == 'available' ? 'success' : (plot.status == 'booked' ? 'danger' : 'secondary')}">${plot.status}</span></p>
                    <p><strong>Description:</strong> ${plot.description || 'No description'}</p>
                `;
            });
        });
    </script>
@endsection