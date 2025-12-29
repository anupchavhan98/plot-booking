<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PlotBook Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; min-height: 100vh; }
        .navbar { background: #343a40; }
        .sidebar { width: 260px; background: #343a40; min-height: 100vh; position: fixed; }
        .sidebar .nav-link { color: #adb5bd; padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #495057; color: #fff; }
        .main-content { margin-left: 260px; padding: 20px; }
        @media (max-width: 992px) {
            .sidebar { margin-left: -260px; transition: 0.3s; }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4 text-center border-bottom">
            <h4 class="text-white mb-0"><i class="fas fa-home text-primary"></i> PlotBook Pro</h4>
            <small class="text-light">Welcome, {{ Auth::user()->name }}</small>
        </div>
        <nav class="mt-3">
            <a href="{{ Auth::user()->hasRole('agent') ? route('agent.dashboard') : route('customer.dashboard') }}"
               class="nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            @if(Auth::user()->hasRole('customer'))
                <a href="{{ route('customer.bookings') }}" class="nav-link {{ request()->routeIs('customer.bookings') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> My Bookings
                </a>
            @endif
            @if(Auth::user()->hasRole('agent'))
                <a href="{{ route('agent.bookings') }}" class="nav-link {{ request()->routeIs('agent.bookings') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> My Bookings
                </a>
                <a href="{{ route('agent.commission') }}" class="nav-link {{ request()->routeIs('agent.commission') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i> Commission
                </a>
            @endif
            <hr class="bg-secondary">
            <a href="{{ route('password.change') }}" class="nav-link">
                <i class="fas fa-key"></i> Change Password
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-link text-danger border-0 bg-transparent text-start w-100">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-dark mb-4">
            <button class="btn btn-light d-lg-none sidebar-toggler">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-text ms-auto text-white">
                {{ Auth::user()->role->name }} Portal
            </span>
        </nav>

        <div class="container-fluid">
            <h3 class="mb-4">@yield('page-title')</h3>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.sidebar-toggler')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
    @yield('scripts')
</body>
</html>