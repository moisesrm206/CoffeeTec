<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CoffeeTec')</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/css/template.css'])
    @else
        <style>
    :root {
        --coffee-dark: #0A2947;
        --coffee-light: #D3D4C0;
        --coffee-cream: #F3E4C9;
        --coffee-gold: #8B5E3C;
    }

    body { background-color: var(--coffee-cream); color: var(--coffee-dark); }
    .navbar, .btn-coffee { background-color: var(--coffee-dark); color: #fff; }
    .btn-coffee:hover { background-color: #081f36; color: #fff; }
    .brand-mark { color: var(--coffee-gold); }
    .product-card { transition: transform .15s ease, box-shadow .15s ease; }
    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(10, 41, 71, .12);
    }
</style>
    @endif
</head>
<body class="bg-coffee-cream text-coffee-dark min-h-screen flex flex-col">
    <nav class="bg-coffee-dark shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span class="text-coffee-gold text-xl font-bold brand-mark">☕</span>
                    <span class="font-bold text-xl tracking-tight text-white">CoffeeTec</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('menu') }}" class="text-coffee-light hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Menú</a>

                        @auth
                            <a href="{{ route('kitchen') }}" class="text-coffee-light hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Cocina</a>

                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.staff.index') }}" class="text-coffee-light hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Personal</a>
                            @endif

                            <a href="{{ route('profile.edit') }}" class="text-coffee-light hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Mi cuenta</a>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-coffee-light hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors bg-transparent border-none cursor-pointer">Salir</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-coffee-light hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Entrar</a>
                        @endauth
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-coffee-light hover:text-white hover:bg-white/10 focus:outline-none">
                        <span class="sr-only">Abrir menú principal</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-4" role="alert">
                    <p class="font-semibold mb-1">Revisa la información:</p>
                    <ul class="list-disc list-inside mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="border-t border-coffee-light/50 bg-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-coffee-dark/70">
            <div>Demo de cafetería escolar · {{ date('Y') }}</div>
            <div class="flex space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="hover:text-coffee-dark transition-colors">Entrar</a>
                @endguest
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
