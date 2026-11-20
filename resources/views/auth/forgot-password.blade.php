@extends('templates.app')

@section('title', 'Recuperar contraseña | CoffeeTec')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 p-8">
            <div class="text-center mb-8">
                <span class="text-coffee-gold text-2xl mb-3">🔑</span>
                <h1 class="text-2xl font-bold text-coffee-dark">Recuperar contraseña</h1>
                <p class="text-coffee-dark/60 text-sm mt-2">Te enviaremos un enlace para restablecer tu contraseña.</p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-coffee-dark mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                        Enviar enlace
                    </button>
                    <a href="{{ route('login') }}" class="text-xs text-coffee-gold underline-offset-4 hover:underline">Volver al acceso</a>
                </div>
            </form>
        </div>
    </div>
@endsection
