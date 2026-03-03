<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Ensalada de Patata Crujiente con Salsa de Yogur',
            'description' => 'Primer Plato',
            'price' => 3.25,
            'image' => 'img/ensaladaPatata.png',
        ]);

        Product::create([
            'name' => 'Albóndigas de Pollo con Crema de Champiñón',
            'description' => 'Segundo Plato',
            'price' => 3.25,
            'image' => 'img/albondigasPollo.png',
        ]);

        Product::create([
            'name' => 'Flan Parisien con Haba Tonka y Vainilla',
            'description' => 'Postre',
            'price' => 1.50,
            'image' => 'img/flanParisien.png',
        ]);
    }
}
