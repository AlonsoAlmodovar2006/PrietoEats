<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $items = ProductOrder::with(['order', 'productOffer.offer', 'productOffer.product'])
            ->whereHas('order', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereHas('productOffer.offer', function ($query) use ($today) {
                $query->whereDate('date_delivery', '>=', $today);
            })
            ->get()
            ->sortByDesc('order.created_at');

        // Agrupamos por el día en que se HIZO la reserva
        $grouped = $items->groupBy(function ($item) {
            return $item->order->created_at->format('Y-m-d');
        });

        return view('orders.userOrders', compact('grouped'));
    }
}
