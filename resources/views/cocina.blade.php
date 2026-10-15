@extends('templates.app')

@section('title', 'Panel de cocina | CoffeeTec')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge text-bg-warning mb-2">OPERACIÓN</span>
            <h1 class="h2 fw-bold mb-1">Panel de cocina</h1>
            <p class="text-muted mb-0">Gestiona los pedidos de la cafetería.</p>
        </div>
        <a href="{{ route('menu') }}" class="btn btn-outline-secondary">Ver menú</a>
    </div>

    @if (!$order)
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-5">
                <div class="display-4 mb-3">🍽️</div>
                <h2 class="h5">No hay pedidos todavía</h2>
                <p class="text-muted mb-0">Crea uno desde el menú para verlo aquí.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm" style="max-width: 600px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                    <div>
                        <span class="text-muted small">ORDEN #{{ str_pad($order['id'], 3, '0', STR_PAD_LEFT) }}</span>
                        <h2 class="h4 mb-0">{{ $order['customer'] }}</h2>
                        <span class="text-muted small">Grupo {{ $order['group'] }}</span>
                    </div>
                    <span class="badge text-bg-{{ $order['status'] === 'Pendiente' ? 'warning' : ($order['status'] === 'Listo' ? 'success' : 'primary') }}">
                        {{ $order['status'] }}
                    </span>
                </div>
                @foreach ($order['items'] as $item)
                    <div class="d-flex justify-content-between py-2">
                        <span>{{ $item['quantity'] }} × {{ $item['name'] }}</span>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between border-top pt-3 mt-2 fw-bold">
                    <span>Total</span><span>${{ number_format($order['total'], 2) }}</span>
                </div>
                @if ($order['status'] !== 'Listo')
                    <form method="POST" action="{{ route('orders.status') }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="status" value="{{ $order['status'] === 'Pendiente' ? 'En preparación' : 'Listo' }}">
                        <button class="btn btn-coffee w-100">
                            Marcar como {{ $order['status'] === 'Pendiente' ? 'en preparación' : 'listo' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif
@endsection
