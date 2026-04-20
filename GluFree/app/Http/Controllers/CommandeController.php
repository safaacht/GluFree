<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\FournisseurProduit;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = auth()->user()->commandes()->with('items.product')->latest()->get();
        return view('commande.index', compact('commandes'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('panier', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['prix'] * $item['quantity'];
        }

        // Create the Commande
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'total_general' => $total,
            'status' => 'en attente'
        ]);

        foreach($cart as $item) {
            // Find the precise inventory record for this supplier and product
            $fournisseurProduit = FournisseurProduit::where('product_id', $item['product_id'])
                                    ->where('fournisseur_id', $item['fournisseur_id'])
                                    ->first();

            if ($fournisseurProduit && $fournisseurProduit->qteStock >= $item['quantity']) {
                // Deduct stock
                $fournisseurProduit->qteStock -= $item['quantity'];
                $fournisseurProduit->save();

                // Attach to order via our new pivot structure
                $commande->items()->attach($fournisseurProduit->id, [
                    'qte' => $item['quantity'],
                    'total_commande' => $item['prix'] * $item['quantity']
                ]);
            }
        }

        // Empty the cart
        session()->forget('panier');

        return redirect()->route('commande.index')->with('success', 'Votre commande a été passée avec succès !');
    }

    /**
     * Fournisseur accepts an order — status becomes livrée.
     */
    public function accepter(Commande $commande)
    {
        $commande->update(['status' => 'livrée']);

        return redirect()->route('fournisseur.commandes')
            ->with('success', 'Commande N°' . str_pad($commande->id, 6, '0', STR_PAD_LEFT) . ' marquée comme livrée.');
    }
}
