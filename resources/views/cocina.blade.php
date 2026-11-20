@extends('templates.app')

@section('title', 'Panel de cocina | CoffeeTec')

@php
    $columns = [
        'pending' => [
            'title' => 'Nuevos pedidos',
            'subtitle' => 'Pendientes de preparar',
            'badge' => 'bg-amber-100 text-amber-800 border-amber-200',
            'dot' => 'bg-amber-500',
            'action' => 'making',
            'actionLabel' => 'Comenzar preparación',
        ],
        'making' => [
            'title' => 'En preparación',
            'subtitle' => 'Pedidos en proceso',
            'badge' => 'bg-blue-100 text-blue-800 border-blue-200',
            'dot' => 'bg-blue-500',
            'action' => 'completed',
            'actionLabel' => 'Marcar como listo',
        ],
        'completed' => [
            'title' => 'Listos',
            'subtitle' => 'Pedidos terminados',
            'badge' => 'bg-green-100 text-green-800 border-green-200',
            'dot' => 'bg-green-500',
        ],
    ];
@endphp

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <span class="inline-block px-3 py-1 rounded-full bg-coffee-gold/10 text-coffee-gold text-xs font-semibold mb-2">OPERACIÓN</span>
            <h1 class="text-2xl font-bold text-coffee-dark mb-1">Panel de cocina</h1>
            <p class="text-coffee-dark/60 text-sm">Gestiona los pedidos de la cafetería.</p>
        </div>
        <a href="{{ route('menu') }}"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-coffee-light/50 bg-white text-coffee-dark text-sm font-medium hover:bg-coffee-gold/50 hover:text-coffee-gold transition-colors">
            Ver menú
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach ($columns as $status => $column)
            <div class="lg:col-span-1">
                <section class="h-full">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-coffee-dark mb-1">{{ $column['title'] }}</h2>
                            <p class="text-xs text-coffee-dark/50">{{ $column['subtitle'] }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md {{ $column['badge'] ?? 'bg-coffee-light/20 text-coffee-dark border border-coffee-light/30' }} text-xs font-semibold">
                            {{ $orders->where('status', $status)->count() }}
                        </span>
                    </div>

                    <div class="flex flex-col gap-3">
                        @forelse ($orders->where('status', $status) as $order)
                            <article class="rounded-lg border border-coffee-light/30 bg-white shadow-sm overflow-hidden flex flex-col">
                                <div class="p-4">
                                    <div class="flex justify-between items-start border-b border-coffee-light/20 pb-3 mb-3">
                                        <div>
                                            <span class="text-xs text-coffee-dark/40">ORDEN #{{ str_pad($order->id_order, 3, '0', STR_PAD_LEFT) }}</span>
                                            <h3 class="text-base font-semibold text-coffee-dark mt-0.5">{{ $order->customer ?? 'Cliente sin nombre' }}</h3>
                                        </div>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full {{ $column['badge'] ?? 'bg-coffee-light/20 text-coffee-dark' }} text-[10px] font-bold uppercase tracking-wider">
                                            {{ $status === 'pending' ? 'Pendiente' : ($status === 'making' ? 'En preparación' : 'Listo') }}
                                        </span>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        @foreach ($order->orderProducts as $orderProduct)
                                            <div class="flex justify-between items-center border-b border-coffee-light/10 pb-2 last:border-0">
                                                <span class="text-sm text-coffee-dark/80">
                                                    {{ $orderProduct->quantity }} × {{ $orderProduct->product->name }}
                                                </span>
                                                <span class="text-sm font-medium text-coffee-dark">${{ number_format($orderProduct->price * $orderProduct->quantity, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="border-t border-coffee-light/20 pt-3 mt-3 flex justify-between items-center font-bold text-sm">
                                        <span class="text-coffee-dark">Total</span>
                                        <span class="text-coffee-dark">${{ number_format($order->total, 2) }}</span>
                                    </div>

                                    @if ($status !== 'completed')
                                        <div class="p-4 border-t border-coffee-light/10 flex flex-col gap-2">
                                            @isset($column['action'])
                                                <form method="POST" action="{{ route('orders.status', $order) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="{{ $column['action'] }}">
                                                    <button type="submit"
                                                        class="w-full py-2 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                                                        {{ $column['actionLabel'] }}
                                                    </button>
                                                </form>
                                            @endisset

                                            <form method="POST" action="{{ route('orders.status', $order) }}"
                                                onsubmit="return confirm('¿Cancelar el pedido #{{ str_pad($order->id_order, 3, '0', STR_PAD_LEFT) }}?{{ $status === 'making' ? ' El stock de sus productos será repuesto.' : '' }}');">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit"
                                                    class="w-full py-2 rounded-lg border border-red-200 bg-red-50 text-red-700 font-medium text-sm hover:bg-red-100 transition-colors active:scale-[0.98]">
                                                    Cancelar pedido
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <div class="rounded-lg border border-dashed border-coffee-light/40 bg-coffee-dark/5 p-6 text-center">
                                <p class="text-xs text-coffee-dark/40">No hay pedidos en esta sección.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        @endforeach
    </div>
@endsection
