<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use RuntimeException;

class ProductSeeder extends Seeder
{
    /**
     * Catálogo real de la cafetería escolar.
     *
     * @var array<int, array{category: string, name: string, description: string, price: float, stock: int, image: string}>
     */
    private const PRODUCTS = [
        // Tortas
        [
            'category' => 'Tortas',
            'name' => 'Torta de chorizo',
            'description' => 'Bolillo con chorizo, queso, lechuga y aderezos.',
            'price' => 45.00,
            'stock' => 20,
            'image' => 'products/torta-chorizo.jpg',
        ],
        [
            'category' => 'Tortas',
            'name' => 'Torta de bistec',
            'description' => 'Bolillo con bistec de res, lechuga, jitomate y aguacate.',
            'price' => 50.00,
            'stock' => 20,
            'image' => 'products/torta-bistec.jpg',
        ],
        [
            'category' => 'Tortas',
            'name' => 'Torta de pierna',
            'description' => 'Pierna de cerdo adobada con lechuga y aderezos.',
            'price' => 45.00,
            'stock' => 20,
            'image' => 'products/torta-pierna.jpg',
        ],
        [
            'category' => 'Tortas',
            'name' => 'Torta de pollo con mole',
            'description' => 'Pollo bañado en mole poblano dentro de bolillo.',
            'price' => 48.00,
            'stock' => 18,
            'image' => 'products/torta-pollo.jpg',
        ],

        // Tacos
        [
            'category' => 'Tacos',
            'name' => 'Taco de bistec',
            'description' => 'Tortilla de maíz con bistec, cebolla, cilantro y salsa.',
            'price' => 22.00,
            'stock' => 30,
            'image' => 'products/taco-bistec.jpg',
        ],
        [
            'category' => 'Tacos',
            'name' => 'Taco de chorizo',
            'description' => 'Tortilla de maíz con chorizo, cebolla y cilantro.',
            'price' => 22.00,
            'stock' => 30,
            'image' => 'products/taco-chorizo.jpg',
        ],
        [
            'category' => 'Tacos',
            'name' => 'Taco de pollo',
            'description' => 'Tortilla de maíz con pollo, lechuga y salsa verde.',
            'price' => 20.00,
            'stock' => 30,
            'image' => 'products/taco-pollo.jpg',
        ],

        // Antojitos
        [
            'category' => 'Antojitos',
            'name' => 'Quesadilla de queso',
            'description' => 'Tortilla de maíz con queso fundido.',
            'price' => 25.00,
            'stock' => 25,
            'image' => 'products/quesadilla-queso.jpg',
        ],
        [
            'category' => 'Antojitos',
            'name' => 'Quesadilla de pollo',
            'description' => 'Tortilla de maíz con pollo y queso fundido.',
            'price' => 35.00,
            'stock' => 20,
            'image' => 'products/quesadilla-pollo.jpg',
        ],
        [
            'category' => 'Antojitos',
            'name' => 'Pambazo',
            'description' => 'Pan bañado en salsa roja con papa, chorizo y lechuga.',
            'price' => 40.00,
            'stock' => 15,
            'image' => 'products/pambazo.jpg',
        ],
        [
            'category' => 'Antojitos',
            'name' => 'Flautas de pollo (orden de 3)',
            'description' => 'Flautas fritas con lechuga, crema y salsa verde.',
            'price' => 45.00,
            'stock' => 15,
            'image' => 'products/flautas.jpg',
        ],
        [
            'category' => 'Antojitos',
            'name' => 'Empanada de queso',
            'description' => 'Empanada frita rellena de queso.',
            'price' => 20.00,
            'stock' => 25,
            'image' => 'products/empanada-queso.jpg',
        ],
        [
            'category' => 'Antojitos',
            'name' => 'Empanada de picadillo',
            'description' => 'Empanada frita rellena de picadillo de res.',
            'price' => 22.00,
            'stock' => 25,
            'image' => 'products/empanada-picadillo.jpg',
        ],
        [
            'category' => 'Antojitos',
            'name' => 'Empanada de mole',
            'description' => 'Empanada frita rellena de mole con pollo.',
            'price' => 22.00,
            'stock' => 20,
            'image' => 'products/empanada-mole.jpg',
        ],

        // Desayunos
        [
            'category' => 'Desayunos',
            'name' => 'Enchiladas suizas',
            'description' => 'Enchiladas rellenas de pollo con salsa verde y queso gratinado.',
            'price' => 55.00,
            'stock' => 15,
            'image' => 'products/enchiladas-suizas.jpg',
        ],
        [
            'category' => 'Desayunos',
            'name' => 'Enchiladas rojas',
            'description' => 'Enchiladas con salsa roja, queso y cebolla.',
            'price' => 50.00,
            'stock' => 15,
            'image' => 'products/enchiladas-rojas.jpg',
        ],
        [
            'category' => 'Desayunos',
            'name' => 'Chilaquiles verdes',
            'description' => 'Totopos con salsa verde, crema, queso y cebolla.',
            'price' => 50.00,
            'stock' => 20,
            'image' => 'products/chilaquiles-verdes.jpg',
        ],
        [
            'category' => 'Desayunos',
            'name' => 'Chilaquiles rojos',
            'description' => 'Totopos con salsa roja, crema, queso y cebolla.',
            'price' => 50.00,
            'stock' => 20,
            'image' => 'products/chilaquiles-rojos.jpg',
        ],

        // Pizza
        [
            'category' => 'Pizza',
            'name' => 'Rebanada de pizza de pepperoni',
            'description' => 'Rebanada cuadrada con pepperoni y queso.',
            'price' => 25.00,
            'stock' => 30,
            'image' => 'products/pizza-pepperoni.jpg',
        ],
        [
            'category' => 'Pizza',
            'name' => 'Rebanada de pizza hawaiana',
            'description' => 'Rebanada cuadrada con jamón y piña.',
            'price' => 25.00,
            'stock' => 30,
            'image' => 'products/pizza-hawaiana.jpg',
        ],

        // Bebidas
        [
            'category' => 'Bebidas',
            'name' => 'Agua de jamaica',
            'description' => 'Agua fresca de jamaica natural, vaso de 500 ml.',
            'price' => 15.00,
            'stock' => 40,
            'image' => 'products/agua-jamaica.jpg',
        ],
        [
            'category' => 'Bebidas',
            'name' => 'Agua de horchata',
            'description' => 'Agua fresca de horchata con canela, vaso de 500 ml.',
            'price' => 15.00,
            'stock' => 40,
            'image' => 'products/agua-horchata.jpg',
        ],
        [
            'category' => 'Bebidas',
            'name' => 'Agua de limón',
            'description' => 'Agua fresca de limón con un toque de azúcar.',
            'price' => 15.00,
            'stock' => 40,
            'image' => 'products/agua-limon.jpg',
        ],
        [
            'category' => 'Bebidas',
            'name' => 'Café de olla',
            'description' => 'Café preparado con canela y piloncillo.',
            'price' => 18.00,
            'stock' => 30,
            'image' => 'products/cafe-de-olla.jpg',
        ],
        [
            'category' => 'Bebidas',
            'name' => 'Agua natural',
            'description' => 'Botella de agua natural de 600 ml.',
            'price' => 12.00,
            'stock' => 50,
            'image' => 'products/agua-natural.jpg',
        ],
        [
            'category' => 'Bebidas',
            'name' => 'Bebida energizante',
            'description' => 'Lata de bebida energizante de 473 ml.',
            'price' => 30.00,
            'stock' => 35,
            'image' => 'products/bebida-energetica.jpg',
        ],

        // Snacks
        [
            'category' => 'Snacks',
            'name' => 'Galletas (paquete)',
            'description' => 'Paquete de galletas con chispas de chocolate.',
            'price' => 15.00,
            'stock' => 40,
            'image' => 'products/galletas.jpg',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::query()->pluck('id_category', 'name');

        foreach (self::PRODUCTS as $product) {
            $categoryId = $categories->get($product['category']);

            if ($categoryId === null) {
                throw new RuntimeException(
                    "Falta la categoría \"{$product['category']}\"; ejecuta primero CategorySeeder."
                );
            }

            Product::query()->updateOrCreate(
                ['name' => $product['name']],
                [
                    'id_category' => $categoryId,
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'image' => $product['image'],
                ],
            );
        }
    }
}
