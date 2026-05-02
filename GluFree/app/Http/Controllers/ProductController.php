<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Models\Category;
use App\Models\Product;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
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

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $product=new Product();
        $product->name=$request['name'];
        $product->description=$request['description'];
        $product->category_id=$request['category_id'];
        $product->price=$request['price'];
        
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

    public function show($id)
    {
        $product=Product::findOrFail($id);
        return view('product.show',compact('product'));
    }

   
    public function edit($id)
    {
        $categories = Category::all();
        $product=Product::findOrFail($id);

        if (auth()->user()->role === 'fournisseur') {
            if (!$product->fournisseurs->contains(auth()->id())) {
                return redirect()->route('product.index')->with('error', 'Vous n\'êtes pas autorisé à modifier ce produit.');
            }
        }

        return view('product.edit',compact('product', 'categories')); 
    
    }


    public function update(UpdateProductRequest $request, $id)
    {
        $product=Product::findOrFail($id);

        if (auth()->user()->role === 'fournisseur') {
            if (!$product->fournisseurs->contains(auth()->id())) {
                return redirect()->route('product.index')->with('error', 'Vous n\'êtes pas autorisé à modifier ce produit.');
            }
        }

        $product->name=$request['name'];
        $product->description=$request['description'];
        $product->category_id=$request['category_id'];
        $product->price=$request['price'];
        
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

    public function destroy($id)
    {
        $product=Product::findOrFail($id);

        if (auth()->user()->role === 'fournisseur') {
            if (!$product->fournisseurs->contains(auth()->id())) {
                return redirect()->route('product.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer ce produit.');
            }
        }

        $product->delete();
        return redirect()->route('product.index')->with('success', 'Produit supprimé avec succès !');
    
    }
}
