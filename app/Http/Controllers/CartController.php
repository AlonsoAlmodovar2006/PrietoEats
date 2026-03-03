<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Offer;
use App\Models\ProductOrder;
use App\Models\ProductOffer;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return view('cart.index', [
                'cart' => [],
                'offersById' => collect(),
                'productOffersById' => collect(),
            ]);
        }

        $offerIds = array_keys($cart);

        $productOfferIds = [];
        foreach ($cart as $offerId => $items) {
            $productOfferIds = array_merge($productOfferIds, array_keys($items));
        }
        $productOfferIds = array_unique($productOfferIds);

        $offersById = Offer::whereIn('id', $offerIds)->get(['id', 'date_delivery', 'time_delivery'])->keyBy('id');

        $productOffersById = ProductOffer::with('product')->whereIn('id', $productOfferIds)->get(['id', 'offer_id', 'product_id'])->keyBy('id');

        return view('cart.index', compact('cart', 'offersById', 'productOffersById'));
    }

    public function add(Request $request, $id)
    {
        $productOffer = ProductOffer::with('offer')->findOrFail($id);

        $cart = session()->get('cart', []);
        $offerId = $productOffer->offer_id;
        $productId = $productOffer->product_id;
        if (!isset($cart[$offerId])) {
            $cart[$offerId] = [];
        }
        if (!isset($cart[$offerId][$id])) {
            $cart[$offerId][$id] = [
                'product_id' => $productId,
                'quantity' => 0,
                'price' => $productOffer->product->price,
            ];
        }
        $cart[$offerId][$id]['quantity']++;
        session()->put('cart', $cart);

        return redirect()->route('home')->with('success', 'Producto añadido al carrito');
    }

    public function increase($id)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $offerId => &$items) {
            if (isset($items[$id])) {
                $items[$id]['quantity']++;
                break;
            }
        }
        unset($items);
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $offerId => &$items) {
            if (isset($items[$id])) {
                $items[$id]['quantity']--;
                if ($items[$id]['quantity'] <= 0) {
                    unset($items[$id]);
                    if (empty($cart[$offerId])) {
                        unset($cart[$offerId]);
                    }
                }
                break;
            }
        }
        unset($items);
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $offerId => &$items) {
            if (isset($items[$id])) {
                unset($items[$id]);
                if (empty($cart[$offerId])) {
                    unset($cart[$offerId]);
                }
                break;
            }
        }
        unset($items);
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        session()->forget('cart');


        return redirect()->route('cart.index');
    }

    public function order()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío');
        }

        DB::transaction(function () {
            $cart = session()->get('cart', []);
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => 0,
            ]);

            $totalPrice = 0;
            foreach ($cart as $offerId => $items) {
                foreach ($items as $productOfferId => $item) {
                    $productOrder = ProductOrder::create([
                        'order_id' => $order->id,
                        'product_offer_id' => $productOfferId,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                    $totalPrice += $item['quantity'] * $item['price'];
                }
            }
            $order->total = $totalPrice;
            $order->save();

            session()->forget('cart');
        });

        return redirect()->route('home')->with('success', 'Reserva creada correctamente');
    }
}
