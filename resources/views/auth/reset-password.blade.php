@extends('templates.app')

@section('title', 'Nueva contraseña | CoffeeTec')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 fw-bold mb-1">Nueva contraseña</h1>
                    <p class="text-muted small mb-4">Define una contraseña de al menos 8 caracteres.</p>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email"
                                name="email" value="{{ old('email', $request->email) }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Nueva contraseña</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password"
                                type="password" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                            <input class="form-control" id="password_confirmation" type="password"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <button class="btn btn-coffee px-4" type="submit">Guardar contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
