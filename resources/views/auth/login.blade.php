@extends('templates.app')

@section('title', 'Entrar | CoffeeTec')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 fw-bold mb-1">Acceso del personal</h1>
                    <p class="text-muted small mb-4">
                        Solo cuentas internas de la cafetería. Los clientes piden desde el menú sin iniciar sesión.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email"
                                name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Contraseña</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password"
                                type="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" id="remember" type="checkbox" name="remember">
                            <label class="form-check-label" for="remember">Recordarme en este equipo</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-coffee px-4" type="submit">Entrar</button>

                            @if (Route::has('password.request'))
                                <a class="small link-secondary" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
