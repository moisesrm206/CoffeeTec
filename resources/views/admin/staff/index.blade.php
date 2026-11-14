@extends('templates.app')

@section('title', 'Personal | CoffeeTec')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-coffee-dark mb-1">Cuentas del personal</h1>
                <p class="text-coffee-dark/60 text-sm">Solo estas cuentas pueden entrar a la cocina y a la administración.</p>
            </div>
            <button type="button" class="px-4 py-2 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]"
                data-collapse-toggle="new-staff">
                Nueva cuenta
            </button>
        </div>

        <div id="new-staff" class="hidden mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 p-6">
                <h2 class="text-sm font-semibold text-coffee-dark/60 uppercase tracking-wider mb-4">Crear cuenta</h2>
                <form method="POST" action="{{ route('admin.staff.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf

                    <div class="md:col-span-2">
                        <label for="new-name" class="block text-sm font-medium text-coffee-dark mb-1">Nombre</label>
                        <input id="new-name" type="text" name="name" value="{{ old('name') }}" required
                            class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="new-email" class="block text-sm font-medium text-coffee-dark mb-1">Correo</label>
                        <input id="new-email" type="email" name="email" value="{{ old('email') }}" required
                            class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label for="new-role" class="block text-sm font-medium text-coffee-dark mb-1">Rol</label>
                        <select id="new-role" name="role" required
                            class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                            @foreach (\App\Enums\UserRole::cases() as $role)
                                <option value="{{ $role->value }}" @selected(old('role') === $role->value)>
                                    {{ $role->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label for="new-password" class="block text-sm font-medium text-coffee-dark mb-1">Contraseña temporal</label>
                        <input id="new-password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label for="new-password-confirmation" class="block text-sm font-medium text-coffee-dark mb-1">Confirmar contraseña</label>
                        <input id="new-password-confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                    </div>

                    <div class="md:col-span-1 flex items-end">
                        <button type="submit"
                            class="w-full py-2.5 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                            Crear cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-coffee-light/20">
                    <thead class="bg-coffee-dark/5">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Correo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Rol</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coffee-light/10 bg-white">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-coffee-dark">{{ $user->name }}</span>
                                        @if ($user->is(auth()->user()))
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-coffee-dark/10 text-coffee-dark text-[10px] font-bold border border-coffee-dark/20">
                                                Tú
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-coffee-dark/80">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full
                                        @if ($user->isAdmin())
                                            bg-amber-100 text-amber-800 border border-amber-200
                                        @else
                                            bg-blue-100 text-blue-800 border border-blue-200
                                        @endif
                                        text-[10px] font-bold uppercase tracking-wider">
                                        {{ $user->role->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button" class="text-coffee-gold hover:text-coffee-dark hover:underline text-sm font-medium"
                                        data-collapse-toggle="staff-{{ $user->id }}">
                                        Editar
                                    </button>

                                    <form method="POST" action="{{ route('admin.staff.destroy', $user) }}" class="inline-block"
                                        onsubmit="return confirm('¿Eliminar la cuenta de {{ $user->name }}?');">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 hover:underline text-sm font-medium ml-2">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <tr id="staff-{{ $user->id }}" class="hidden bg-coffee-dark/5">
                                <td colspan="4" class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.staff.update', $user) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        @csrf
                                        @method('patch')

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-coffee-dark mb-1">Nombre</label>
                                            <input type="text" name="name" value="{{ $user->name }}" required
                                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-coffee-dark mb-1">Correo</label>
                                            <input type="email" name="email" value="{{ $user->email }}" required
                                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                                        </div>

                                        <div class="md:col-span-1">
                                            <label class="block text-sm font-medium text-coffee-dark mb-1">Rol</label>
                                            <select name="role"
                                                @disabled($user->is(auth()->user()))
                                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all @disabled($user->is(auth()->user())) ? 'bg-coffee-dark/5 text-coffee-dark/40' : ''">
                                                @foreach (\App\Enums\UserRole::cases() as $role)
                                                    <option value="{{ $role->value }}" @selected($user->role === $role)>
                                                        {{ $role->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($user->is(auth()->user()))
                                                <input type="hidden" name="role" value="{{ $user->role->value }}">
                                            @endif
                                        </div>

                                        <div class="md:col-span-1">
                                            <label class="block text-sm font-medium text-coffee-dark mb-1">Nueva contraseña</label>
                                            <input type="password" name="password" autocomplete="new-password" placeholder="Opcional"
                                                class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                                        </div>

                                        <div class="md:col-span-1 flex items-end">
                                            <button type="submit"
                                                class="w-full py-2.5 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                                                Guardar
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="text-coffee-dark/40 text-sm">Todavía no hay cuentas registradas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
