<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FournisseurProduit;

class PanierController extends Controller
{
    public function index()
    {
        $cart = session()->get('panier', []);
        $total = 0;
        
        foreach($cart as $key => &$item) {
            $fp = FournisseurProduit::where('product_id', $item['product_id'])
                                    ->where('fournisseur_id', $item['fournisseur_id'])
                                    ->first();
                                    
            $maxStock = $fp ? $fp->qteStock : 0;
            $item['max_stock'] = $maxStock;
            
            if($item['quantity'] > $maxStock) {
                $item['quantity'] = max(0, $maxStock);
            }
            
            $total += $item['prix'] * $item['quantity'];
        }
        session()->put('panier', $cart);
        
        return view('panier.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $cart = session()->get('panier', []);
        
        $fournisseur_id = $request->input('fournisseur_id');
        $prix = $request->input('prix');
        
        // Use a composite key or just id if supplier doesn't change
        $cartKey = $id . '_' . $fournisseur_id;
        $quantity = (int) $request->input('quantity', 1);

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "prix" => $prix,
                "fournisseur_id" => $fournisseur_id,
                "photo" => $product->photo,
            ];
        }
        
        session()->put('panier', $cart);
        
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès !');
    }

    public function update(Request $request, $key)
    {
        $cart = session()->get('panier', []);
        if(isset($cart[$key])) {
            // Re-check stock just to be safe
            $item = $cart[$key];
            $fp = FournisseurProduit::where('product_id', $item['product_id'])
                                    ->where('fournisseur_id', $item['fournisseur_id'])
                                    ->first();
            
            $maxStock = $fp ? $fp->qteStock : 0;
            $newQuantity = max(1, (int) $request->input('quantity', 1));
            
            $cart[$key]['quantity'] = min($newQuantity, $maxStock);
            session()->put('panier', $cart);
        }
        return redirect()->route('panier.index')->with('success', 'Quantité mise à jour.');
    }

    public function remove($key)
    {
        $cart = session()->get('panier', []);
        if(isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('panier', $cart);
        }
        return redirect()->route('panier.index')->with('success', 'Produit retiré du panier.');
    }
}
