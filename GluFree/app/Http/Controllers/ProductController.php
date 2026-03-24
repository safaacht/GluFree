<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Models\Category;
use App\Models\Product;
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
        $products= $productService->getProductsBy($search,$category);
        $categories=Category::all();
        return view('product.index',compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product=new Product();
        $product->name=$request['name'];
        $product->description=$request['description'];
        $product->price=$request['price'];
        $product->quantitéStock=$request['quantitéStock'];
        $product->category_id=$request['category_id'];
        $product->photo=$request['photo'];
        $product->certificationSansGluten=$request['certificationSansGluten'];
        $product->save();

            return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product=Product::findOrFail($id);
        return view('product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $categories = Category::all();
        $product=Product::findOrFail($id);
        return view('product.edit',compact('product', 'categories')); 
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $product=new Product();
        $product->name=$request['name'];
        $product->description=$request['description'];
        $product->price=$request['price'];
        $product->quantitéStock=$request['quantitéStock'];
        $product->category_id=$request['category_id'];
        $product->photo=$request['photo'];
        $product->certificationSansGluten=$request['certificationSansGluten'];
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès !');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès !');
    
    }
}
