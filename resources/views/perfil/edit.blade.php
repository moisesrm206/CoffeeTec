@extends('templates.app')

@section('title', 'Mi cuenta | CoffeeTec')

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 p-8">
            <h1 class="text-xl font-bold text-coffee-dark mb-6">Mi cuenta</h1>

            @if (session('status') === 'profile-updated')
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">Datos actualizados.</div>
            @elseif (session('status') === 'password-updated')
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">Contraseña actualizada.</div>
            @endif

            <div class="space-y-8">
                <div>
                    <h2 class="text-sm font-semibold text-coffee-dark/60 uppercase tracking-wider mb-4">Datos personales</h2>
                    <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="name" class="block text-sm font-medium text-coffee-dark mb-1">Nombre</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                            @error('name', 'updateProfileInformation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-coffee-dark mb-1">Correo electrónico</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                            @error('email', 'updateProfileInformation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 flex items-end gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-coffee-light/20 text-coffee-dark text-xs font-semibold border border-coffee-light/30">
                                Rol: {{ $user->role->label() }}
                            </span>
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit"
                                class="w-auto py-2.5 px-6 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>

                <div class="border-t border-coffee-light/20 pt-6">
                    <h2 class="text-sm font-semibold text-coffee-dark/60 uppercase tracking-wider mb-4">Cambiar contraseña</h2>
                    <form method="POST" action="{{ route('password.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-coffee-dark mb-1">Contraseña actual</label>
                            <input id="current_password" type="password" name="current_password" required autocomplete="current-password"
                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                            @error('current_password', 'updatePassword')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-coffee-dark mb-1">Nueva contraseña</label>
                            <input id="new_password" type="password" name="password" required autocomplete="new-password"
                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                            @error('password', 'updatePassword')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-coffee-dark mb-1">Confirmar nueva contraseña</label>
                            <input id="new_password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                        </div>

                        <div class="md:col-span-2 flex items-end">
                            <button type="submit"
                                class="w-auto py-2.5 px-6 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                                Actualizar contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
