<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    
    {
        $faker = Faker::create('es_MX');
        for ($i = 0; $i < 30; $i++) {
            Product::create([
                'id_category' => $faker->numberBetween(1, 2),
                'name' => $faker->foodName(),
                'description' => $faker->sentence(),
                'price' => $faker->randomFloat(2, 10, 100),
                'stock' => $faker->numberBetween(1, 50),
                //'image' => $faker->imageUrl(640, 480, 'food', true),
            ]);
        }
    
    }
}
