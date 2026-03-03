<?php

namespace Database\Seeders;

use App\Models\ProductOffer;
use Illuminate\Database\Seeder;

class ProductOfferSeeder extends Seeder
{
    public function run(): void
    {
        ProductOffer::create([
            'offer_id' => 1,
            'product_id' => 1
        ]);

        ProductOffer::create([
            'offer_id' => 1,
            'product_id' => 2
        ]);

        ProductOffer::create([
            'offer_id' => 1,
            'product_id' => 3
        ]);
    }
}
