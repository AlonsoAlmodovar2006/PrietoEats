<?php

namespace App\Http\Controllers\auth\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // 1. Traemos los ProductOrder directamente, que es la unidad que tiene la información
        $items = ProductOrder::with(['order.user', 'productOffer.offer', 'productOffer.product'])
            ->get()
            ->sortByDesc('productOffer.offer.date_delivery');

        // 2. Agrupamos por la fecha de la oferta
        $grouped = $items->groupBy(function ($item) {
            return $item->productOffer->offer->date_delivery->format('Y-m-d');
        });

        return view('orders.listOrders', compact('grouped'));
    }
}
