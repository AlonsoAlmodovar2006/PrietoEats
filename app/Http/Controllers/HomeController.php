<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $offers = Offer::with("productsOffer.product")->where('date_delivery', '>=', now()->toDateString())->get();

        return view('home', ['ofertas' => $offers]);
    }
}
