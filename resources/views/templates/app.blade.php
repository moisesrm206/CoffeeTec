<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CoffeeTec')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --coffee-dark: #4b2e20;
            --coffee-light: #d6a77a;
            --coffee-cream: #fff8ef;
        }

        body { background: var(--coffee-cream); }
        .navbar, .btn-coffee { background-color: var(--coffee-dark); }
        .btn-coffee { color: #fff; }
        .btn-coffee:hover { background-color: #352016; color: #fff; }
        .brand-mark { color: var(--coffee-light); }
        .product-card { transition: transform .15s ease, box-shadow .15s ease; }
        .product-card:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(75, 46, 32, .12); }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('menu') }}">
                <span class="brand-mark">☕</span> CoffeeTec
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('menu') }}">Menú</a>
                <a class="nav-link" href="{{ route('kitchen') }}">Cocina</a>
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="py-3 text-center text-muted small">
        Demo de cafetería escolar · {{ date('Y') }}
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
