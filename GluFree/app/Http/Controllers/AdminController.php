<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            // 'total_Fournisseur' => Fournisseur::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
        ];

        $products = Product::with('category')->latest()->take(10)->get();
        $categories = Category::all();

        return view('admin.dashboard', compact('stats', 'products', 'categories'));
    }
}
