<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Plot Booking Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom Styles -->
     
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #343a40;
            --sidebar-hover: #495057;
            --primary-color: #0d6efd;
        }

        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #495057;
        }

        .sidebar .logo h3 {
            color: #fff;
            margin: 0;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }

        .top-navbar {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 70px;
            padding: 0 20px;
        }

        .content-area {
            padding: 30px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 25px;
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }

        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggler {
                display: block !important;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h3><i class="fas fa-home text-primary"></i> PlotBook Pro</h3>
        </div>
        <nav class="mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.plots.index') }}" class="nav-link {{ request()->routeIs('admin.plots.*') ? 'active' : '' }}">
                <i class="fas fa-th"></i> Plot Management
            </a>
            <a href="{{ route('admin.plots.layout') }}" class="nav-link {{ request()->routeIs('admin.plots.layout') ? 'active' : '' }}">
                <i class="fas fa-map"></i> Plot Layout View
            </a>
            <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Customers
            </a>
            <a href="{{ route('admin.agents.index') }}" class="nav-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i> Agents
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Bookings
            </a>
            <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Payments
            </a>
            <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
            <hr class="bg-secondary my-3">
            <a href="{{ route('password.change') }}" class="nav-link">
                <i class="fas fa-key"></i> Change Password
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button class="btn sidebar-toggler d-lg-none me-3">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <h4 class="mb-0">@yield('page-title')</h4>
            </div>
            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-2x me-2"></i>
                    <span class="d-none d-md-block">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('password.change') }}">Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="text-center py-4 text-muted border-top mt-5">
            <small>&copy; {{ date('Y') }} Plot Booking Management System. All rights reserved.</small>
        </footer>
    </div>

    <!-- Toast Container -->
    <div class="toast-container">
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.querySelector('.sidebar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Auto-hide toast after 5 seconds
        document.querySelectorAll('.toast').forEach(toast => {
            new bootstrap.Toast(toast, { delay: 5000 }).show();
        });
    </script>

    @yield('scripts')
    <!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>