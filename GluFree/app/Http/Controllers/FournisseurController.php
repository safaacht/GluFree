<?php

namespace App\Http\Controllers;
use App\Models\Fournisseur;
use App\Models\FournisseurProduit;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreFournisseurRequest;
use App\Http\Requests\UpdateFournisseurRequest;

class FournisseurController extends Controller
{
    public function index()
    {
        $products = collect();
        $total_products = 0;
        $chiffre_affaires = 0;

        if (auth()->check()) {
            $fournisseur = Fournisseur::find(auth()->id());
            if ($fournisseur) {
                $products = $fournisseur->produits()->paginate(10);
                $total_products = $fournisseur->produits()->count();

                // les ids des FournisseurProduit appartenant à ce fournisseur
                $fpIds = FournisseurProduit::where('fournisseur_id', auth()->id())->pluck('id');

                // le total des  prix vendus
                $chiffre_affaires = DB::table('ProduitCommander')
                    ->whereIn('fournisseur_produit_id', $fpIds)
                    ->sum('total_commande');
            }
        }
        return view('fournisseur.dashboard', compact('products', 'total_products', 'chiffre_affaires'));
    }

    public function create()
    {
        return view('fournisseur.create');
    }

    public function store(StoreFournisseurRequest $request)
    {
        $fournisseur= new Fournisseur();
        $fournisseur->name=$request['name'];
        $fournisseur->email=$request['email'];
        $fournisseur->password=$request['password'];
        $fournisseur->role=$request['role'];
        $fournisseur->save();

        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur ajouté avec succès !');
    }

    public function show($id)
    {
        $fournisseur=Fournisseur::findOrFail($id);
        return view('fournisseur.show',compact('fournisseur'));
    }

    public function edit($id)
    {
        $fournisseur=Fournisseur::findOrFail($id);
        return view('fournisseur.edit',compact('fournisseur'));
    }

    public function update(UpdateFournisseurRequest $request, $id)
    {
        $fournisseur=Fournisseur::findOrFail($id);
        $fournisseur->name=$request['name'];
        $fournisseur->email=$request['email'];
        $fournisseur->password=$request['password'];
        $fournisseur->role=$request['role'];
        $fournisseur->save();

        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $fournisseur=Fournisseur::findOrFail($id);
        $fournisseur->delete();
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur supprimé avec succès !');
    }
    public function commandes()
    {
        //  all FournisseurProduit records belonging to this fournisseur
        $fournisseurProduitIds = FournisseurProduit::where('fournisseur_id', auth()->id())
            ->pluck('id');

        // commandes that have at least one item from this fournisseur
        $commandes = Commande::whereHas('items', function ($q) use ($fournisseurProduitIds) {
                $q->whereIn('fournisseur_produit_id', $fournisseurProduitIds);
            })
            ->with(['items' => function ($q) use ($fournisseurProduitIds) {
                $q->whereIn('fournisseur_produit_id', $fournisseurProduitIds)
                  ->with('product');
            }, 'user'])
            ->latest()
            ->paginate(5);

        return view('fournisseur.commandes', compact('commandes'));
    }
}
