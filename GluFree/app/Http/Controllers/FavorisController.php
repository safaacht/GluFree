<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavorisController extends Controller
{
    public function index()
    {
        $favoris = auth()->user()->favoris()->with('category', 'fournisseurs')->get();
        return view('favoris.index', compact('favoris'));
    }

    public function store(Product $product)
    {
        auth()->user()->favoris()->syncWithoutDetaching([$product->id]);
        return redirect()->back()->with('success', 'Produit ajouté aux favoris !');
    }

    public function destroy(Product $product)
    {
        auth()->user()->favoris()->detach($product->id);
        return redirect()->back()->with('success', 'Produit retiré des favoris !');
    }
}
