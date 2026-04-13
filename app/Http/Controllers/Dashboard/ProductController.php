<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    if ($request->ajax()) {
        $products = Product::latest()->get();
        return $this->fillDataTable($request);
        exit;
    }

        return view('portal.products.index');

    }

       // Create Form
    public function create()
    {
        $product = new Product(); // empty product for form
        $categories = Category::all();
        return view('portal.products.form', compact('product','categories'));
    }

    // Store
public function store(Request $request)
{
    $data = $request->validate([
        'category_id' => 'required|integer|exists:categories,id',
        'name'        => 'required|string|max:255',
        'slug'        => 'required|string|max:255|unique:products,slug',
        'description' => 'nullable|string',

        'price'       => 'required|numeric',
        'sale_price'  => 'nullable|numeric|lt:price',

        'stock'       => 'required|integer',
        'sku'         => 'required|string|max:255|unique:products,sku',

        'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle Checkboxes
    $data['is_active']   = $request->has('is_active');
    $data['is_featured'] = $request->has('is_featured');
    $data['sale_price'] =  (!empty($request->sale_price) ? $request->sale_price : $request->price);

    // Handle Thumbnail Upload
    if ($request->hasFile('thumbnail')) {
        $data['thumbnail'] = $request->file('thumbnail')
                                     ->store('products', 'public');
    }

    Product::create($data);

    return redirect()
        ->route('dashboard.products.index')
        ->with('success', 'Product added successfully!');
}

    // Edit Form
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('portal.products.form', compact('product','categories'));
    }

    // update
public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'category_id' => 'required|integer|exists:categories,id',
        'name'        => 'required|string|max:255',
        'slug'        => 'required|string|max:255|unique:products,slug,' . $product->id,
        'description' => 'nullable|string',

        'price'       => 'required|numeric',
        'sale_price'  => 'nullable|numeric',

        'stock'       => 'required|integer',
        'sku'         => 'required|string|max:255|unique:products,sku,' . $product->id,

        'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle Checkboxes
    $data['is_active'] = $request->has('is_active');
    $data['is_featured'] = $request->has('is_featured');

    // Handle Thumbnail Upload
    if ($request->hasFile('thumbnail')) {

        // Delete old thumbnail
       // 1️⃣ Delete old image
    if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
        Storage::disk('public')->delete($product->thumbnail);

    }

    // 2️⃣ Store new image
    $data['thumbnail'] = $request->file('thumbnail')
                                 ->store('products', 'public');

        $data['thumbnail'] = $request->file('thumbnail')
                                     ->store('products', 'public');
    }

    $product->update($data);

    return redirect()
        ->route('dashboard.products.index')
        ->with('success', 'Product updated successfully!');
}

    // Destroy
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('dashboard.products.index')->with('success', 'Product deleted successfully!');
    }

public function fillDataTable(Request $request)
{

    $columns = ['id', 'name', 'price', 'stock'];

    // Base query
    $query = Product::query();

    // Total records count
    $totalData = $query->count();

    // Search functionality
    if ($search = $request->input('search.value')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('price', 'like', "%{$search}%")
              ->orWhere('stock', 'like', "%{$search}%");
        });
    }

    $totalFiltered = $query->count();

    // Ordering
    $orderColumnIndex = $request->input('order.0.column', 0);
    $orderColumn = $columns[$orderColumnIndex] ?? 'id';
    $orderDir = $request->input('order.0.dir', 'desc');

    // Pagination
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);

    $products = $query->orderBy($orderColumn, $orderDir)
                      ->skip($start)
                      ->take($length)
                      ->get();

    // Format data for DataTable
    $data = $products->map(function ($product) {
        return [
            $product->id,
            $product->name,
            $product->price,
            $product->stock,
            view('portal.products.partials.actions', compact('product'))->render()
        ];
    });


    // JSON response
    return response()->json([
        "draw" => intval($request->input('draw')),
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $data
    ]);
}


}
