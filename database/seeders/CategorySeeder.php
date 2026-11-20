<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Categorías del menú de la cafetería.
     *
     * @var array<int, array{name: string, description: string}>
     */
    private const CATEGORIES = [
        [
            'name' => 'Tortas',
            'description' => 'Tortas preparadas con diferentes carnes.',
        ],
        [
            'name' => 'Tacos',
            'description' => 'Tacos de bistec, chorizo y pollo.',
        ],
        [
            'name' => 'Antojitos',
            'description' => 'Quesadillas, pambazos, flautas y empanadas.',
        ],
        [
            'name' => 'Desayunos',
            'description' => 'Enchiladas y chilaquiles preparados al momento.',
        ],
        [
            'name' => 'Pizza',
            'description' => 'Rebanadas cuadradas de pizza.',
        ],
        [
            'name' => 'Bebidas',
            'description' => 'Aguas frescas, café de olla y bebidas embotelladas.',
        ],
        [
            'name' => 'Snacks',
            'description' => 'Productos listos para llevar.',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::CATEGORIES as $category) {
            Category::query()->updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']],
            );
        }
    }
}
