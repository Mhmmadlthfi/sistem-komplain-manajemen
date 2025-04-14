<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query();

        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $products->where(function ($q) use ($search) {
                $q->where('product_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $products = $products->orderBy('id', 'desc')->paginate(5);

        foreach ($products as $product) {
            $product->can_delete = $product->saleDetail()->count() == 0;
        }

        return view('admin.produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'product_code' => 'required|max:255',
                'name' => 'required|max:255',

            ]
        );

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.produk.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate(
            [
                'product_code' => 'required|max:255',
                'name' => 'required|max:255',

            ]
        );

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!Gate::allows('marketing')) {
            abort(403);
        }

        if ($product->saleDetail()->count() !== 0) {
            return redirect()->back()->with('error', 'Data produk ini telah terhubung ke data penjualan, tidak dapat dihapus.');
        }

        Product::destroy($product->id);
        return redirect()->route('products.index')->with('success', 'Data Produk berhasil dihapus.');
    }
}
