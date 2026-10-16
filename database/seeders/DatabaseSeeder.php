<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
        
        $comida = Category::create([
            'name' => 'Comidas',
            'description' => 'Alimentos preparados para el menú escolar.',
        ]);

        $bebidas = Category::create([
            'name' => 'Bebidas',
            'description' => 'Bebidas frías y calientes.',
        ]);

        Product::create([
            'id_category' => $comida->id_category,
            'name' => 'Sándwich de pollo',
            'description' => 'Pan artesanal, pollo y vegetales.',
            'price' => 35,
            'stock' => 20,
        ]);

        Product::create([
            'id_category' => $comida->id_category,
            'name' => 'Hamburguesa escolar',
            'description' => 'Carne, queso, lechuga y jitomate.',
            'price' => 45,
            'stock' => 20,
        ]);

        Product::create([
            'id_category' => $bebidas->id_category,
            'name' => 'Jugo natural',
            'description' => 'Jugo del día, sin conservadores.',
            'price' => 18,
            'stock' => 30,
        ]);

        Product::create([
            'id_category' => $bebidas->id_category,
            'name' => 'Café con leche',
            'description' => 'Café caliente preparado al momento.',
            'price' => 20,
            'stock' => 30,
        ]);
    }
}
