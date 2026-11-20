@extends('templates.app')

@section('title', 'Entrar | CoffeeTec')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 p-8">
            <div class="text-center mb-8">
                <span class="text-coffee-gold text-2xl mb-3">☕</span>
                <h1 class="text-2xl font-bold text-coffee-dark">Acceso del personal</h1>
                <p class="text-coffee-dark/60 text-sm mt-2">Solo cuentas internas de la cafetería. Los clientes piden desde el menú sin iniciar sesión.</p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-coffee-dark mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-coffee-dark mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="rounded border-coffee-light/50 text-coffee-gold focus:ring-coffee-gold">
                    <label for="remember" class="ml-2 block text-sm text-coffee-dark/70">Recordarme en este equipo</label>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                        Entrar
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <p class="text-center text-sm text-coffee-dark/60">
                        <a href="{{ route('password.request') }}" class="font-medium text-coffee-gold hover:underline">¿Olvidaste tu contraseña?</a>
                    </p>
                @endif
            </form>
        </div>
    </div>
@endsection
