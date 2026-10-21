@extends('templates.app')

@section('title', 'Panel de cocina | CoffeeTec')

@php
    $columns = [
        'pending' => [
            'title' => 'Nuevos pedidos',
            'subtitle' => 'Pendientes de preparar',
            'badge' => 'warning',
            'action' => 'making',
            'actionLabel' => 'Comenzar preparación',
        ],
        'making' => [
            'title' => 'En preparación',
            'subtitle' => 'Pedidos en proceso',
            'badge' => 'primary',
            'action' => 'completed',
            'actionLabel' => 'Marcar como listo',
        ],
        'completed' => [
            'title' => 'Listos',
            'subtitle' => 'Pedidos terminados',
            'badge' => 'success',
        ],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge text-bg-warning mb-2">OPERACIÓN</span>
            <h1 class="h2 fw-bold mb-1">Panel de cocina</h1>
            <p class="text-muted mb-0">Gestiona los pedidos de la cafetería.</p>
        </div>
        <a href="{{ route('menu') }}" class="btn btn-outline-secondary">Ver menú</a>
    </div>

    <div class="row g-4">
        @foreach ($columns as $status => $column)
            <div class="col-12 col-lg-4">
                <section class="h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="h4 fw-bold mb-1">{{ $column['title'] }}</h2>
                            <p class="text-muted small mb-0">{{ $column['subtitle'] }}</p>
                        </div>
                        <span class="badge text-bg-{{ $column['badge'] }}">
                            {{ $orders->where('status', $status)->count() }}
                        </span>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse ($orders->where('status', $status) as $order)
                            <article class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                        <div>
                                            <span class="text-muted small">
                                                ORDEN #{{ str_pad($order->id_order, 3, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <h3 class="h5 mb-0">{{ $order->customer ?? 'Cliente sin nombre' }}</h3>
                                        </div>
                                        <span class="badge text-bg-{{ $column['badge'] }}">
                                            {{ $status === 'pending' ? 'Pendiente' : ($status === 'making' ? 'En preparación' : 'Listo') }}
                                        </span>
                                    </div>

                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($order->orderProducts as $orderProduct)
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                    {{ $orderProduct->quantity }} ×
                                                    {{ $orderProduct->product->name }}
                                                </span>
                                                <span>
                                                    ${{ number_format($orderProduct->price * $orderProduct->quantity, 2) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex justify-content-between border-top pt-3 mt-3 fw-bold">
                                        <span>Total</span>
                                        <span>${{ number_format($order->total, 2) }}</span>
                                    </div>

                                    @isset($column['action'])
                                        <form method="POST" action="{{ route('orders.status', $order) }}" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="status" value="{{ $column['action'] }}">
                                            <button class="btn btn-coffee w-100">
                                                {{ $column['actionLabel'] }}
                                            </button>
                                        </form>
                                    @endisset
                                </div>
                            </article>
                        @empty
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center text-muted py-4">
                                    No hay pedidos en esta sección.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        @endforeach
    </div>
@endsection
