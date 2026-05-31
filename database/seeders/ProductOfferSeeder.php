<?php

namespace Database\Seeders;

use App\Models\ProductOffer;
use Illuminate\Database\Seeder;

class ProductOfferSeeder extends Seeder
{
    public function run(): void
    {
        ProductOffer::firstOrCreate([
            'offer_id' => 1,
            'product_id' => 1,
        ]);

        ProductOffer::firstOrCreate([
            'offer_id' => 1,
            'product_id' => 2,
        ]);

        ProductOffer::firstOrCreate([
            'offer_id' => 1,
            'product_id' => 3,
        ]);
    }
}
