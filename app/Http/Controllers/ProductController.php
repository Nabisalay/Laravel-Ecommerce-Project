<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Show all Categories on add product page
    public function show(): View
    {
        $categories = CategoryModel::all();
        return view('admin.addproduct', ['categories' => $categories]);
    }

    // Show products using pagination of 5 per each page
    public function showProducts(): View
    {
        $products = ProductModel::where('status', true)->paginate(5);
        return view('admin.viewproducts', ['products' => $products]);
    }

    // Fetch product for the home page of the appliaction
    public function fatchProducts(): View
    {
        $products = ProductModel::where('status', true)->orderBy('id')->limit(9)->get();
        return view('welcome', ['products' => $products]);
    }

    // Show all the product and category in the shop 
    public function showProductsInShop(): View
    {
        $categories = CategoryModel::all();
        $products = ProductModel::where('status', true)->orderBy('id')->paginate(9);
        return view('shop', ['products' => $products, 'categories' => $categories]);
    }

    // Add new product in the database and website
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'warranty' => ['required', 'integer', 'max:255'],
            'Warranty_type' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

        ]);
        $maxProductId = ProductModel::max('prodCode');
        $nextProductId = str_pad($maxProductId + 1, 5, '0', STR_PAD_LEFT);
        $ProductUID = $request->category . $nextProductId;
        $imagePath = $request->file('image')->store('images', 'public');

        ProductModel::create([
            'description' => $request->description,
            'price' => $request->price,
            'warrenty' => $request->warranty . ' ' . $request->Warranty_type,
            'prodImg' => $imagePath,
            'prodCode' => $nextProductId,
            'CategoryNo' => $request->category,
            'prodId' => $ProductUID,
        ]);

        session()->flash('productAdded', 'Product has been added successfully');

        return redirect()->back();
    }

    // Get the product to udpate it 
    public function showUpdateView($id): View
    {
        $categories = CategoryModel::all();
        $item = DB::table('products as p')->select('p.*', 'c.cid', 'c.cname')
            ->join('category as c', 'p.CategoryNo', '=', 'c.cid')
            ->where('p.id', '=', $id)
            ->first();
        return view('admin.updateproduct', ['item' => $item, 'categories' => $categories]);
    }

    // update the product information
    public function updateProduct(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'warranty' => ['required', 'integer', 'max:255'],
            'Warranty_type' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        $ProductUID = $request->category . $request->product_code;
        $imagePath = $request->file('image')->store('images', 'public');

        ProductModel::where('id', $id)
            ->update([
                'description' => $request->description,
                'price' => $request->price,
                'warrenty' => $request->warranty . ' ' . $request->Warranty_type,
                'prodImg' => $imagePath,
                'CategoryNo' => $request->category,
                'prodId' => $ProductUID,
            ]);

        session()->flash('productUpdated', 'Product has been updated Successfully');

        return redirect()->route('view.products');
    }

    // Delete the product 
    public function deleteProduct($id): RedirectResponse
    {
        ProductModel::find($id)->delete();

        session()->flash('productDeleted', 'product has been deleted Successfully');
        return redirect()->back();
    }
}
