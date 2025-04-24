<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get(); // pastikan relasi kategori diikutkan
        $categories = Category::all(); // Ambil semua kategori
        return view('products.index', compact('products', 'categories'));
    }
    


    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        // Validasi input (optional, sesuaikan dengan kebutuhan)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        // Update produk
        $product->update($validatedData);
    
        // Redirect ke halaman produk
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }
    
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }


    public function destroy(Product $product)
    {
        $product->delete();
       
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

