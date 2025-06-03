<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at','desc')->get(); // pastikan relasi kategori diikutkan
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs('products', $imageName, 'public'); // ← disk 'public'
            $data['image'] = $imageName;
        }



        Product::create($data);
        \Log::info('Gambar disimpan di: public/products/' . $imageName);


        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }
    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists('public/products/' . $product->image)) {
                Storage::delete('public/products/' . $product->image);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs('products', $imageName, 'public');
            $validatedData['image'] = $imageName;
        }

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }


    public function destroy(Product $product)
    {
        if ($product->image && Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
   public function report(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = Product::with('category');

    if ($startDate && $endDate) {
        $start = Carbon::parse($startDate)->startOfDay();  
        $end = Carbon::parse($endDate)->endOfDay();        

        $query->whereBetween('created_at', [$start, $end]);
    }

    $products = $query->get();

    return view('products.report', compact('products', 'startDate', 'endDate'));
}
}

