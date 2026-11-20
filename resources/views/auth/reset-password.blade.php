@extends('templates.app')

@section('title', 'Nueva contraseña | CoffeeTec')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 p-8">
            <div class="text-center mb-8">
                <span class="text-coffee-gold text-2xl mb-3">🔒</span>
                <h1 class="text-2xl font-bold text-coffee-dark">Nueva contraseña</h1>
                <p class="text-coffee-dark/60 text-sm mt-2">Define una contraseña de al menos 8 caracteres.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-coffee-dark mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-coffee-dark mb-1">Nueva contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-coffee-dark mb-1">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2.5 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                    Guardar contraseña
                </button>
            </form>
        </div>
    </div>
@endsection
