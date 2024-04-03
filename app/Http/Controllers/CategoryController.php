<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // Show all the categories to the dashboard
    public function showCategories(): View
    {
        $categories = CategoryModel::select('category.cid', 'category.cname', 'category.is_active', DB::raw('COUNT(products.id) as product_count'))
            ->leftJoin('products', 'category.cid', '=', 'products.CategoryNo')
            ->groupBy('category.cid', 'category.cname', 'category.is_active')
            ->paginate(5);

        return view('admin.viewcategories', ['categories' => $categories]);
    }


    // Store a new category 
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
        ]);

        $maxCId = CategoryModel::max('cid');
        $nextCId = str_pad($maxCId + 1, 2, '0', STR_PAD_LEFT);

        CategoryModel::create([
            'cid' => $nextCId,
            'cname' => $request->category_name,
        ]);
        session()->flash('categoryAdded', 'Category has been added successfully');
        return redirect()->back();
    }
    
    public function updateCategory($cid, $status)
    {
        CategoryModel::where('cid', $cid)->update(['is_active' => $status]);
        ProductModel::where('CategoryNo', $cid)->update(['status' => $status]);
        $variable = $status ? 'activated' : 'deactivated';
        session()->flash('categoryUpdated', 'Category has been ' . $variable . ' successfully');
        return redirect()->route('view.category');
    }
}
