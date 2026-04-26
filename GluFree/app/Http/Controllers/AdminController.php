<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_Fournisseur' => Fournisseur::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
        ];

        $fournisseurs = Fournisseur::latest()->paginate(10, ['*'], 'fournisseurs_page');
        $products = Product::with('category')->latest()->paginate(10, ['*'], 'products_page');
        $categories = Category::all();

        return view('admin.dashboard', compact('stats', 'products', 'categories', 'fournisseurs'));
    }

    public function acceptFournisseur(Fournisseur $fournisseur)
    {
        $fournisseur->update(['status' => 'accepté']);
        return back()->with('success', 'Fournisseur accepté avec succès.');
    }

    public function refuserFournisseur(Fournisseur $fournisseur)
    {
        $fournisseur->update(['status' => 'refusé']);
        return back()->with('success', 'Fournisseur refusé.');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produit supprimé.');
    }
}
