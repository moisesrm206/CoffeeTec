@extends('templates.app')

@section('title', "{{ $product ? 'Editar' : 'Nuevo' }} producto | CoffeeTec")

@section('content')
    <div class="max-w-xl mx-auto py-8">
        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 p-6 md:p-8">
            <div class="mb-6">
                <h1 class="text-xl font-bold text-coffee-dark mb-1">{{ $product ? 'Editar producto' : 'Nuevo producto' }}</h1>
                <p class="text-coffee-dark/60 text-sm">Completa los datos del platillo.</p>
            </div>

            <form method="POST" action="{{ $product ? route('admin.products.update', $product) : route('admin.products.store') }}"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if ($product)
                    @method('patch')
                @endif

                <div>
                    <label for="name" class="block text-sm font-medium text-coffee-dark mb-1">Nombre del producto</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product?->name) }}" required
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="id_category" class="block text-sm font-medium text-coffee-dark mb-1">Categoría</label>
                    <select id="id_category" name="id_category" required
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}" @selected(old('id_category', $product?->id_category) === $category->id_category)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_category')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-coffee-dark mb-1">Descripción</label>
                    <textarea id="description" name="description" rows="3"
                        class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark placeholder-coffee-dark/30 focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">{{ old('description', $product?->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-coffee-dark mb-1">Precio</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-coffee-dark/50">$</span>
                            <input id="price" type="number" step="0.01" name="price" value="{{ old('price', $product?->price) }}" required
                                class="block w-full pl-8 rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                        </div>
                        @error('price')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-coffee-dark mb-1">Stock</label>
                        <input id="stock" type="number" name="stock" value="{{ old('stock', $product?->stock) }}" required
                            class="block w-full rounded-lg border border-coffee-light/50 bg-white py-2.5 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none transition-all">
                        @error('stock')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-coffee-dark mb-1">Imagen del producto</label>
                    <input id="image" type="file" name="image" accept="image/*"
                        class="block w-full text-coffee-dark/60 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-coffee-gold file:text-white hover:file:bg-coffee-dark/90">
                    @if ($product?->image)
                        <p class="mt-2 text-xs text-coffee-dark/50">
                            Imagen actual: <a href="{{ Storage::url($product->image) }}" target="_blank" class="text-coffee-gold hover:underline">Ver imagen</a>
                        </p>
                    @endif
                    @error('image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-6">
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-coffee-dark text-white font-medium text-sm hover:bg-coffee-gold transition-colors active:scale-[0.98]">
                        {{ $product ? 'Guardar cambios' : 'Crear producto' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-lg border border-coffee-light/30 bg-white text-coffee-dark font-medium text-sm text-center hover:bg-coffee-dark/5 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
