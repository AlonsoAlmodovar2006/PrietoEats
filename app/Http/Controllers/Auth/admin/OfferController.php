<?php

namespace App\Http\Controllers\Auth\admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with("productsOffer.product")->get(); // Ordenar de nueva a antigua
        return view('offers.listOffers', compact("offers"));
    }

    public function create()
    {
        $products = Product::orderBy('id', 'asc')->get();
        return view('offers.createOffer', compact("products"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_delivery' => 'required|date_format:Y-m-d|after:today',
            'time_delivery' => 'required|string|max:255',
            'producto_selected' => 'required|array|min:1',
            'producto_selected.*' => 'integer|distinct|exists:products,id',
        ]);

        DB::transaction(function () use ($validated) {
            $offer = Offer::create([
                "date_delivery" => $validated['date_delivery'],
                "time_delivery" => $validated['time_delivery']
            ]);
            //obtener un array con los ids de los productos incluidos en la oferta
            $productIds = $validated['producto_selected'];
            //convertimos una lista de IDs de productos en una colección que contiene un array asociativo con los ids
            $rows = collect($productIds)->map(fn($id) => ['product_id' => $id])->values()->all();
            //utilizamos estos datos para el método CreateMany que insertará los registros en producto_offers
            $offer->productsOffer()->createMany($rows);
            $offer->save();
        });
        return redirect()->route('admin.offers.index')->with('success', 'Oferta creada');
    }

    public function destroy($id)
    {
        Offer::destroy($id);
        return redirect()->route('admin.offers.index')->with('success', 'Oferta borrada');
    }
}
