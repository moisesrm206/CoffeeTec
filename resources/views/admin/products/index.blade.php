@extends('templates.app')

@section('title', 'Productos | CoffeeTec')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-coffee-dark mb-1">Productos</h1>
                <p class="text-coffee-dark/60 text-sm">Gestiona el menú de la cafetería.</p>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="px-4 py-2 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                Nuevo producto
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-coffee-light/20">
                    <thead class="bg-coffee-dark/5">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Imagen</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Categoría</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Precio</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Stock</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-coffee-dark/60 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coffee-light/10 bg-white">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                            class="w-16 h-16 object-cover rounded-md border border-coffee-light/30">
                                    @else
                                        <div class="w-16 h-16 rounded-md bg-coffee-dark/10 flex items-center justify-center border border-coffee-light/30">
                                            <span class="text-coffee-dark/30 text-xs">Sin imagen</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-coffee-dark">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-coffee-dark/70">
                                    {{ $product->category->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-coffee-dark">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($product->stock > 0)
                                            bg-green-100 text-green-800
                                        @else
                                            bg-red-100 text-red-800
                                        @endif">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-coffee-gold hover:text-coffee-dark hover:underline mr-3">Editar</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline-block"
                                        onsubmit="return confirm('¿Eliminar el producto {{ $product->name }}?');">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-coffee-dark/40 text-sm">Todavía no hay productos registrados.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
