<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource for the public menu.
     */
    public function index(): View
    {
        return view('menu', [
            'categories' => Category::query()
                ->orderBy('name')
                ->get(),
            'products' => Product::query()
                ->with('category')
                ->where('stock', '>', 0)
                ->orderBy('name')
                ->get(),
        ]);
    }

    /**
     * Display a listing of the resource for administrators.
     */
    public function adminIndex(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()->with('category')->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.products.form', [
            'categories' => Category::query()->orderBy('name')->get(),
            'product' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_category' => ['required', 'exists:categories,id_category'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($validated);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo guardar el producto: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'categories' => Category::query()->orderBy('name')->get(),
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'id_category' => ['required', 'exists:categories,id_category'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($validated);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Producto actualizado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo actualizar el producto: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'No se pudo eliminar el producto: '.$e->getMessage());
        }
    }
}
