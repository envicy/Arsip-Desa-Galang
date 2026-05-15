<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Desa Galang</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            background-color: #f5f7fb; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
            margin: 4px 12px;
            border-radius: 8px;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover { 
            background: #f9fafb; 
            color: #4f46e5;
        }

        .sidebar a.active {
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 600;
        }

        .main-wrapper {
            margin-left: 240px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            min-height: 100vh;
        }

        .content { 
            flex-grow: 1;
            padding: 2rem; 
        }

        footer {
            background: white;
            padding: 1.25rem 0;
            border-top: 1px solid #e5e7eb;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); transition: 0.3s; }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body class="h-100">

    <div class="sidebar">
        <div class="sidebar-brand">
            <h5 class="mb-0 fw-bold text-primary text-uppercase">
                <i class="fas fa-chart-pie me-2"></i>Desa Galang
            </h5>
        </div>
        
        <div class="mt-3">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            <a href="{{ route('surat-masuk.index') }}" class="{{ request()->routeIs('surat-masuk*') ? 'active' : '' }}">
                <i class="fas fa-envelope me-2"></i> Surat Masuk
            </a>
            <a href="{{ route('surat-keluar.index') }}" class="{{ request()->routeIs('surat-keluar*') ? 'active' : '' }}">
                <i class="fas fa-paper-plane me-2"></i> Surat Keluar
            </a>

            {{-- MENU KHUSUS ADMIN --}}
            @if(auth()->user()->peran == 'admin')
            <a href="{{ route('operator.index') }}" class="{{ request()->routeIs('operator*') ? 'active' : '' }}">
                <i class="fas fa-user-cog me-2"></i> Operator
            </a>
            @endif
        </div>

        <div class="mt-auto p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light text-danger w-100 text-start d-flex align-items-center" style="border-radius: 8px;">
                    <i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-wrapper">
        <main class="content">
            @yield('content')
        </main>

        <footer>
            <div class="container-fluid px-4">
                <div class="row align-items-center justify-content-between flex-column flex-md-row">
                    <div class="col-auto">
                        <div class="small text-muted">
                            &copy; {{ date('Y') }} <span class="fw-semibold">Desa Galang</span>. All Rights Reserved.
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="small text-muted mt-1 mt-md-0">
                            Developed by <span class="text-primary fw-bold">Ikbal Sawaludin</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>