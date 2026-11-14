@extends('templates.app')

@section('title', 'Personal | CoffeeTec')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Cuentas del personal</h1>
            <p class="text-muted small mb-0">Solo estas cuentas pueden entrar a la cocina y a la administración.</p>
        </div>
        <button class="btn btn-coffee" type="button" data-bs-toggle="collapse" data-bs-target="#new-staff"
            aria-expanded="false" aria-controls="new-staff">
            Nueva cuenta
        </button>
    </div>

    <div class="collapse mb-4" id="new-staff">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h6 fw-semibold mb-3">Crear cuenta</h2>

                <form method="POST" action="{{ route('admin.staff.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" for="new-name">Nombre</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="new-name" type="text"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="new-email">Correo</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="new-email" type="email"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="new-role">Rol</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="new-role" name="role"
                                required>
                                @foreach (\App\Enums\UserRole::cases() as $role)
                                    <option value="{{ $role->value }}" @selected(old('role') === $role->value)>
                                        {{ $role->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="new-password">Contraseña temporal</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="new-password"
                                type="password" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="new-password-confirmation">Confirmar contraseña</label>
                            <input class="form-control" id="new-password-confirmation" type="password"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-coffee w-100" type="submit">Crear cuenta</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Rol</th>
                        <th scope="col" class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-semibold">
                                {{ $user->name }}
                                @if ($user->is(auth()->user()))
                                    <span class="badge text-bg-light ms-1">Tú</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->isAdmin() ? 'text-bg-dark' : 'text-bg-warning' }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#staff-{{ $user->id }}" aria-expanded="false"
                                    aria-controls="staff-{{ $user->id }}">
                                    Editar
                                </button>

                                <form method="POST" action="{{ route('admin.staff.destroy', $user) }}" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar la cuenta de {{ $user->name }}?');">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        <tr class="collapse" id="staff-{{ $user->id }}">
                            <td colspan="4" class="bg-body-tertiary">
                                <form method="POST" action="{{ route('admin.staff.update', $user) }}">
                                    @csrf
                                    @method('patch')

                                    <div class="row g-3 py-2">
                                        <div class="col-md-3">
                                            <label class="form-label" for="name-{{ $user->id }}">Nombre</label>
                                            <input class="form-control" id="name-{{ $user->id }}" type="text"
                                                name="name" value="{{ $user->name }}" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label" for="email-{{ $user->id }}">Correo</label>
                                            <input class="form-control" id="email-{{ $user->id }}" type="email"
                                                name="email" value="{{ $user->email }}" required>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label" for="role-{{ $user->id }}">Rol</label>
                                            <select class="form-select" id="role-{{ $user->id }}" name="role"
                                                @disabled($user->is(auth()->user()))>
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

                                        <div class="col-md-2">
                                            <label class="form-label" for="password-{{ $user->id }}">Nueva contraseña</label>
                                            <input class="form-control" id="password-{{ $user->id }}" type="password"
                                                name="password" autocomplete="new-password"
                                                placeholder="Opcional">
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-coffee w-100" type="submit">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Todavía no hay cuentas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
