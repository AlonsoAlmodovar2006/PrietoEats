<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OffersSeeder extends Seeder
{
    public function run(): void
    {
        Offer::create([
            'date_delivery' => Carbon::parse('2026-02-25'),
            'time_delivery' => '13:35-14:30',
        ]);
    }
}
