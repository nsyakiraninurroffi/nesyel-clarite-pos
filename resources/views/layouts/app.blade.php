<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NESYÈL CLARITÉ - POS System</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    
    <!-- Google Fonts: Poppins & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            /* Professional Dashboard Gen-Z Light Palette */
            --primary-pink: #f8a1c4;
            --secondary-pink: #fbc2eb;
            --accent-purple: #a18cd1;
            --dark-purple: #8f7cc3;
            --gold-accent: #d4af37;
            --nude-beige: #fef6f8;
            --bg-color: #fdfafc;
            --text-color: #3f334d;
            --text-muted: #8a7c93;
            --card-bg: #ffffff;
            --shadow-sm: 0 4px 15px rgba(161, 140, 209, 0.15);
            --shadow-md: 0 8px 25px rgba(161, 140, 209, 0.25);
            --radius-md: 16px;
            --radius-lg: 24px;
            --border-color: #f3e8f5;
            --nav-bg: rgba(255, 255, 255, 0.85);
            --input-bg: #ffffff;
        }

        [data-theme="dark"] {
            /* Dark Mode Deep Purple/Mocha Palette */
            --primary-pink: #b66d8e;
            --secondary-pink: #b97aa2;
            --accent-purple: #7966a3;
            --dark-purple: #9c8abd;
            --nude-beige: #2a2230;
            --gold-accent: #d4af37;
            --bg-color: #1e1823;
            --text-color: #f5f0f6;
            --text-muted: #c2aec7;
            --card-bg: #2d2435;
            --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.4);
            --border-color: #40344b;
            --nav-bg: rgba(45, 36, 53, 0.85);
            --input-bg: #1e1823;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.5px;
        }

        /* Navbar Glassmorphism */
        .navbar {
            background-color: var(--nav-bg) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: var(--shadow-sm);
            padding: 16px 0;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--gold-accent) !important;
            font-size: 1.5rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: opacity 0.2s ease;
        }
        .navbar-brand:hover { opacity: 0.85; }

        .nav-link {
            font-weight: 500;
            color: var(--text-color) !important;
            transition: all 0.25s ease;
            margin: 0 4px;
            padding: 8px 18px !important;
            border-radius: 30px;
            font-size: 0.95rem;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--border-color);
            color: var(--gold-accent) !important;
        }
        .nav-link.active {
            font-weight: 600;
        }

        /* Card Styling */
        .card {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            background: var(--card-bg);
            box-shadow: var(--shadow-sm);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.3s ease, border-color 0.3s ease;
            margin-bottom: 20px;
        }
        .card:hover {
            box-shadow: var(--shadow-md);
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 25px;
            font-size: 1.35rem;
            color: var(--gold-accent);
        }

        /* Buttons Aesthetic */
        .btn-custom, .btn-primary {
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            color: #fff !important;
            border: none;
            border-radius: 30px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 10px rgba(161, 140, 209, 0.3);
            letter-spacing: 0.5px;
        }

        .btn-custom:hover, .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 18px rgba(161, 140, 209, 0.45);
        }
        .btn-custom:active, .btn-primary:active {
            transform: translateY(0) scale(0.97);
            box-shadow: 0 2px 6px rgba(161, 140, 209, 0.3);
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--gold-accent);
            border: 1px solid var(--gold-accent);
            border-radius: 30px;
            padding: 10px 24px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .btn-outline-custom:hover {
            background: var(--border-color);
            color: var(--gold-accent);
            transform: translateY(-1px);
        }
        .btn-outline-custom:active {
            transform: translateY(0) scale(0.97);
        }

        /* Generic btn active press */
        .btn:active:not(:disabled) {
            transform: scale(0.97);
        }

        /* Table Styling */
        .table {
            vertical-align: middle;
            color: var(--text-color);
        }
        
        .table thead th {
            border-bottom: 1px solid var(--border-color);
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            background-color: transparent;
        }
        
        .table tbody td {
            background-color: transparent;
            border-bottom: 1px dashed var(--border-color);
        }

        /* Forms */
        .form-control, .form-select {
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 14px 18px;
            transition: all 0.25s ease;
            background-color: var(--input-bg);
            color: var(--text-color);
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(161, 140, 209, 0.2);
            border-color: var(--accent-purple);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dark-mode-toggle {
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--border-color);
            color: var(--accent-purple);
            transition: 0.3s;
        }
        .dark-mode-toggle:hover {
            transform: rotate(15deg) scale(1.1);
        }

        .footer-text {
            text-align: center;
            padding: 20px 0;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: auto;
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        /* Dropdown polish */
        .dropdown-menu {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            animation: fadeIn 0.2s ease;
        }
        .dropdown-item {
            color: var(--text-color);
            transition: background 0.2s ease;
            border-radius: 8px;
            margin: 0 6px;
            width: calc(100% - 12px);
        }
        .dropdown-item:hover {
            background: var(--border-color);
            color: var(--text-color);
        }

        /* Skeleton Loading Utility */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, var(--border-color) 25%, var(--card-bg) 50%, var(--border-color) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 12px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-purple);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: var(--card-bg);
                border-radius: 16px;
                padding: 16px;
                margin-top: 12px;
                box-shadow: var(--shadow-md);
                border: 1px solid var(--border-color);
            }
            .nav-link { margin: 4px 0; }
        }
        @media (max-width: 576px) {
            .container { padding-left: 16px; padding-right: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand brand-font d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 40px; height: 40px; margin-right: 12px; border-radius: 50%; object-fit: cover; box-shadow: var(--shadow-sm);">
                NESYÈL CLARITÉ
            </a>
            <button class="navbar-toggler border-0 shadow-none text-gold" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="fa-solid fa-bars" style="color: var(--gold-accent);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                            Kasir
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaksi.history') ? 'active' : '' }}" href="{{ route('transaksi.history') }}">
                            History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                            Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                            Produk
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="dark-mode-toggle shadow-sm" id="themeToggle">
                        <i class="fa-solid fa-moon"></i>
                    </div>
                    
                    <!-- User Profile Dropdown -->
                    @auth
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle rounded-pill p-1 shadow-sm border" style="background: var(--card-bg);" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple)); font-size: 0.8rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-truncate fw-medium" style="max-width: 100px; font-size: 0.9rem; color: var(--text-color);">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="dropdownUser" style="border-radius: 12px; min-width: 200px;">
                            <li class="px-3 py-2 text-muted small fw-semibold">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.index') }}">
                                    <i class="fa-solid fa-user-circle me-2 text-muted"></i> Profile
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-5 fade-in">
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#d4af37',
                    background: 'var(--card-bg)',
                    color: 'var(--text-color)',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            </script>
        @endif

        @yield('content')
    </main>

    <footer class="footer-text mt-auto w-100">
        &copy; 2026 NESYÈL CLARITÉ. All rights reserved.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark Mode Logic
        const themeToggle = document.getElementById('themeToggle');
        const icon = themeToggle.querySelector('i');
        const currentTheme = localStorage.getItem('theme');

        if (currentTheme) {
            document.documentElement.setAttribute('data-theme', currentTheme);
            if(currentTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        }

        themeToggle.addEventListener('click', () => {
            let theme = document.documentElement.getAttribute('data-theme');
            let targetTheme = theme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);
            
            if(targetTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
