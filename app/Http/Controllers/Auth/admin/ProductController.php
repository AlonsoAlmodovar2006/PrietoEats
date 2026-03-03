<?php

namespace App\Http\Controllers\auth\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->get();
        return view('products.listProducts', compact("products"));
    }

    public function create()
    {
        return view('products.createProduct');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|string|max:100",
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $product = new Product();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            if ($request->file('image')) {
                $file = $request->file('image');
                $product->image = $file->store('img', 'public');
            }
            $product->name = $request->input('name');
            $product->save();
        } catch (Exception $e) {
            error("El producto no se puede registrar" . $e);
        }
        return redirect()->route('admin.products.index')->with('success', 'Producto creado');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => "required|string|max:100",
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->update($validated);
        } catch (Exception $e) {
            error("El producto no se puede registrar" . $e);
        }
        return redirect()->route('admin.products.index')->with('success', 'Producto editado');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('admin.products.index')->with('success', 'Producto borrado');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.editProduct', compact("product"));
    }
}
