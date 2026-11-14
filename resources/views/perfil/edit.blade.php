@extends('templates.app')

@section('title', 'Mi cuenta | CoffeeTec')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h4 fw-bold mb-4">Mi cuenta</h1>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">Datos actualizados.</div>
            @elseif (session('status') === 'password-updated')
                <div class="alert alert-success">Contraseña actualizada.</div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3">Datos personales</h2>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label" for="name">Nombre</label>
                            <input class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror"
                                id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name', 'updateProfileInformation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror"
                                id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email', 'updateProfileInformation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <p class="text-muted small mb-3">Rol: {{ $user->role->label() }}</p>

                        <button class="btn btn-coffee" type="submit">Guardar cambios</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3">Cambiar contraseña</h2>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label" for="current_password">Contraseña actual</label>
                            <input class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                id="current_password" type="password" name="current_password" required
                                autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="new_password">Nueva contraseña</label>
                            <input class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                id="new_password" type="password" name="password" required autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="new_password_confirmation">Confirmar nueva contraseña</label>
                            <input class="form-control" id="new_password_confirmation" type="password"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <button class="btn btn-coffee" type="submit">Actualizar contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
