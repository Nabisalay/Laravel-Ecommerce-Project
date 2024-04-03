<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Http\Request;

class HandleSearchController extends Controller
{
    // Dashboard search for admin
    public function dashboardSearchQuery(Request $request)
    {
        $request->validate([
            'search_query' => ['required', 'string', 'max:255'],
        ]);

        $searchQuery = $request->search_query;

        // First check if the query is for user
        $users = User::where('name', 'like', "%$searchQuery%")
            ->orwhere('email', 'like', "%$searchQuery%")
            ->get();
        if ($users->count() > 0) {
            session()->flash('userfound', 'records found');
            return view('admin.index', ['users' => $users]);
        } else {
            // Check if the query is for the product 
            $products = ProductModel::where('description', 'like', "%$searchQuery%")
                ->get();
            if ($products->count() > 0) {
                session()->flash('productfound', 'records found');
                return view('admin.index', ['products' => $products]);
            } else {
                // check if the query is for the category 
                $categories = CategoryModel::where('cname', 'like', "%$searchQuery%")
                    ->get();
                if ($categories->count() > 0) {
                    session()->flash('categoryfound', 'records found');
                    return view('admin.index', ['categories' => $categories]);
                } else {
                    session()->flash('noRecordFound', 'there isn\'t any records matched with your query. Try it again');
                    return view('admin.index');
                }
            }
        }
    }

    // Search with in the application for the user 
    public function searchProduct(Request $request)
    {
        $request->validate([
            'search_query' => ['required', 'string', 'max:255'],
        ]);

        $searchQuery = $request->search_query;
        $categories = CategoryModel::all();
        $products = ProductModel::where('description', 'like', "%$searchQuery%")
            ->get();
        if ($products->count() > 0) {
            session()->flash('productfound', 'records found');

            return view('shop', ['categories' => $categories, 'products' => $products,]);
        } else {
            session()->flash('noRecordFound', 'there isn\'t any records matched with your query. Try it again');
            return view('shop', ['categories' => $categories]);
        }
    }

    // Search product by category 
    public function searchProductByCategory(Request $request)
    {
        $request->validate([
            'search_by_category' => ['required', 'string', 'max:255'],
        ]);

        $searchByCategory = $request->search_by_category;
        $categories = CategoryModel::all();
        if ($searchByCategory !== 'All') {
            $products = ProductModel::where('CategoryNo', 'like', "%$searchByCategory%")
                ->get();
        } else {
            $products = ProductModel::where('status', 1)->get();
        }
        if ($products->count() > 0) {
            session()->flash('productfound', 'records found');

            return view('shop', ['categories' => $categories, 'products' => $products,]);
        } else {
            session()->flash('noRecordFound', 'there isn\'t any records matched with your query. Try it again');
            return view('shop', ['categories' => $categories]);
        }
    }
}
