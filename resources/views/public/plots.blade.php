<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Available Plots - PlotBook Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .plot-card {
            transition: transform 0.3s;
            cursor: pointer;
        }
        .plot-card:hover { transform: scale(1.05); }
        .available { border-left: 5px solid #28a745; }
        .booked { border-left: 5px solid #dc3545; opacity: 0.7; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.plots') }}">
                <i class="fas fa-home"></i> PlotBook Pro
            </a>
            <div>
                @auth
                    <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : (Auth::user()->hasRole('agent') ? route('agent.dashboard') : route('customer.dashboard')) }}" class="btn btn-outline-light me-2">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="text-center mb-5">Available Plots for Booking</h2>

        <div class="row g-4">
            @foreach($plots as $plot)
                <div class="col-md-4 col-sm-6">
                    <div class="card plot-card h-100 shadow {{ $plot->status == 'available' ? 'available' : 'booked' }}"
                         @if($plot->status == 'available') data-bs-toggle="modal" data-bs-target="#bookingModal" data-plot-id="{{ $plot->id }}" @endif>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $plot->plot_number }}</h5>
                            <p><strong>Size:</strong> {{ number_format($plot->size, 2) }} sq.ft</p>
                            <p><strong>Price:</strong> ₹{{ number_format($plot->price, 2) }}</p>
                            <p><strong>Location:</strong> {{ $plot->location ?? 'N/A' }}</p>
                            <span class="badge bg-{{ $plot->status == 'available' ? 'success' : 'danger' }} fs-6">
                                {{ ucfirst($plot->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('public.book.plot') }}">
                    @csrf
                    <input type="hidden" name="plot_id" id="plot_id">
                    <div class="modal-header">
                        <h5>Book This Plot</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @guest
                            <div class="alert alert-info">
                                Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a> to book a plot.
                            </div>
                        @else
                            <p>Confirm booking for <strong id="plot_number"></strong>?</p>
                            <div class="mb-3">
                                <label>Booking Amount (Token)</label>
                                <input type="number" name="booking_amount" class="form-control" placeholder="e.g. 50000" required>
                            </div>
                            <div class="mb-3">
                                <label>Notes (Optional)</label>
                                <textarea name="notes" class="form-control" rows="3"></textarea>
                            </div>
                        @endguest
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        @auth
                            <button type="submit" class="btn btn-success">Submit Booking Request</button>
                        @endauth
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.plot-card.available').forEach(card => {
            card.addEventListener('click', function() {
                document.getElementById('plot_id').value = this.dataset.plotId;
                document.getElementById('plot_number').textContent = this.querySelector('.card-title').textContent;
            });
        });
    </script>
</body>
</html>