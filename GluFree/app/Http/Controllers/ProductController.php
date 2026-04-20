<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Models\Category;
use App\Models\Product;
use App\Models\City;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,ProductService $productService)
    {
        $search= $request->query("search");
        $category= $request->query("category");
        $city = $request->query("city");
        $products= $productService->getProductsBy($search,$category,$city);
        $categories=Category::all();
        $cities = City::all();
        return view('product.index',compact('products','categories', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'fournisseur' && auth()->user()->status !== 'accepté') {
            return redirect()->back()->with('error', 'Votre compte est en attente de validation par l\'administrateur.');
        }

        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'fournisseur' && auth()->user()->status !== 'accepté') {
            return redirect()->back()->with('error', 'Votre compte est en attente de validation par l\'administrateur.');
        }

        $product=new Product();
        $product->name=$request['name'];
        $product->description=$request['description'];
        $product->category_id=$request['category_id'];
        
        if ($request->hasFile('photo')) {
            $product->photo = $request->file('photo')->store('products', 'public');
        }

        $product->certificationSansGluten = $request->has('certificationSansGluten') ? 1 : 0;
        $product->save();

        if (auth()->user()->role === 'fournisseur') {
            auth()->user()->produits()->attach($product->id, [
                'qteStock' => $request['quantitéStock'],
                'prix' => $request['price']
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Produit ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product=Product::findOrFail($id);
        return view('product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (auth()->user()->role === 'fournisseur' && auth()->user()->status !== 'accepté') {
            return redirect()->back()->with('error', 'Votre compte est en attente de validation par l\'administrateur.');
        }

        $categories = Category::all();
        $product=Product::findOrFail($id);
        return view('product.edit',compact('product', 'categories')); 
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'fournisseur' && auth()->user()->status !== 'accepté') {
            return redirect()->back()->with('error', 'Votre compte est en attente de validation par l\'administrateur.');
        }

        $product=Product::findOrFail($id);
        $product->name=$request['name'];
        $product->description=$request['description'];
        $product->category_id=$request['category_id'];
        
        if ($request->hasFile('photo')) {
            $product->photo = $request->file('photo')->store('products', 'public');
        }

        $product->certificationSansGluten = $request->has('certificationSansGluten') ? 1 : 0;
        $product->save();

        if (auth()->check() && auth()->user()->role === 'fournisseur') {
            auth()->user()->produits()->syncWithoutDetaching([
                $product->id => [
                    'qteStock' => $request['quantitéStock'] ?? 0,
                    'prix' => $request['price'] ?? 0
                ]
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Produit mis à jour avec succès !');    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (auth()->user()->role === 'fournisseur' && auth()->user()->status !== 'accepté') {
            return redirect()->back()->with('error', 'Votre compte est en attente de validation par l\'administrateur.');
        }

        $product=Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Produit supprimé avec succès !');
    
    }
}
