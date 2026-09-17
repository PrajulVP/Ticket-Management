<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TicketDesk Enterprise' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --bg-body: #0b1120;
            --panel-bg: #151f32;
            --panel-card: #1c273e;
            --panel-card-hover: #22304c;
            --border-glow: rgba(99, 102, 241, 0.25);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --brand-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --brand-glow: 0 8px 24px -4px rgba(99, 102, 241, 0.45);
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-body);
            color: #f1f5f9;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 270px;
            background: #0f172a;
            border-right: 1px solid var(--border-subtle);
            min-height: 100vh;
            position: sticky;
            top: 0;
        }

        .brand-box {
            background: var(--brand-gradient);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            box-shadow: var(--brand-glow);
        }

        .nav-item-custom {
            color: #94a3b8;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.925rem;
            margin-bottom: 0.35rem;
            transition: all 0.2s ease;
        }

        .nav-item-custom:hover {
            background: rgba(99, 102, 241, 0.12);
            color: #c7d2fe;
            transform: translateX(3px);
        }

        .nav-item-custom.active {
            background: var(--brand-gradient);
            color: #ffffff;
            font-weight: 600;
            box-shadow: var(--brand-glow);
        }

        /* Card System */
        .card-panel {
            background: var(--panel-card);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            transition: all 0.25s ease;
        }

        .card-stat {
            background: linear-gradient(180deg, #1e293b 0%, #151f32 100%);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 18px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .card-stat::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border-subtle);
        }

        .card-stat.stat-primary::after { background: #6366f1; }
        .card-stat.stat-warning::after { background: #f59e0b; }
        .card-stat.stat-success::after { background: #10b981; }
        .card-stat.stat-info::after { background: #06b6d4; }

        /* Form Inputs (Crisp & High-Contrast) */
        .form-control-slate, .form-select-slate {
            background: #0f172a !important;
            border: 1.5px solid #334155 !important;
            color: #ffffff !important;
            border-radius: 12px;
            padding: 0.85rem 1.15rem;
            font-size: 0.95rem;
        }

        .form-control-slate:focus, .form-select-slate:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25) !important;
            outline: none;
        }

        .form-control-slate::placeholder {
            color: #64748b !important;
        }

        /* Buttons */
        .btn-brand {
            background: var(--brand-gradient);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.01em;
            box-shadow: var(--brand-glow);
            transition: all 0.2s ease;
        }

        .btn-brand:hover {
            opacity: 0.95;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 28px -2px rgba(99, 102, 241, 0.6);
        }

        /* Custom Table */
        .table-custom {
            --bs-table-bg: transparent;
            color: #f1f5f9;
            margin-bottom: 0;
        }

        .table-custom thead th {
            background: #0f172a;
            color: #94a3b8;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .table-custom tbody td {
            padding: 1.1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .table-custom tbody tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .badge-pill-custom {
            padding: 0.4rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.775rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
    </style>
</head>
<body>
    <div class="d-flex min-vh-100">
        @auth
        <!-- Left Side Navigation -->
        <aside class="sidebar p-4 d-flex flex-column flex-shrink-0">
            <div class="d-flex align-items-center gap-3 mb-4 px-2">
                <div class="brand-box d-flex align-items-center justify-content-center text-white">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-white tracking-wide">TicketDesk</h5>
                    <span class="text-secondary small" style="font-size: 0.72rem;">ENTERPRISE V2.0</span>
                </div>
            </div>

            <hr style="border-color: var(--border-subtle);" class="my-2">

            <nav class="flex-grow-1 mt-3">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-item-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill fs-5"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.tasks.index') }}" class="nav-item-custom {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                        <i class="bi bi-check2-square fs-5"></i> Task Operations
                    </a>
                    <a href="{{ route('admin.staff.index') }}" class="nav-item-custom {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill fs-5"></i> Staff Directory
                    </a>
                @else
                    <a href="{{ route('staff.dashboard') }}" class="nav-item-custom {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 fs-5"></i> Dashboard
                    </a>
                    <a href="{{ route('staff.tasks.index') }}" class="nav-item-custom {{ request()->routeIs('staff.tasks.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task fs-5"></i> My Assigned Tasks
                    </a>
                    <a href="{{ route('staff.profile') }}" class="nav-item-custom {{ request()->routeIs('staff.profile') ? 'active' : '' }}">
                        <i class="bi bi-person-gear fs-5"></i> Profile Settings
                    </a>
                @endif
            </nav>

            <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-subtle);">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="overflow-hidden me-2">
                        <div class="fw-bold text-white text-truncate small">{{ auth()->user()->name }}</div>
                        <div class="text-secondary text-capitalize small" style="font-size: 0.7rem;">{{ auth()->user()->role }}</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" title="Sign Out">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        @endauth

        <!-- Main Body Area -->
        <div class="d-flex flex-column flex-grow-1 min-vw-0">
            @auth
            <header class="py-3 px-4 px-md-5 d-flex justify-content-between align-items-center" style="background: rgba(15, 23, 42, 0.6); border-bottom: 1px solid var(--border-subtle);">
                <div class="text-secondary small">
                    <i class="bi bi-calendar3 me-1"></i> {{ date('l, F j, Y') }}
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge-pill-custom" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">
                        <i class="bi bi-shield-fill-check"></i> System Operational
                    </span>
                </div>
            </header>
            @endauth

            <main class="flex-grow-1 p-4 p-md-5">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 text-white d-flex align-items-center gap-3 p-3 mb-4 shadow-sm" style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4) !important;">
                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-4 text-white d-flex align-items-center gap-3 p-3 mb-4 shadow-sm" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4) !important;">
                        <i class="bi bi-exclamation-octagon-fill text-danger fs-4"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="py-3 px-4 px-md-5 text-center text-secondary small" style="border-top: 1px solid var(--border-subtle); background: #0b1120;">
                TicketDesk Enterprise &bull; Role-Based Ticket Dispatching System
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>