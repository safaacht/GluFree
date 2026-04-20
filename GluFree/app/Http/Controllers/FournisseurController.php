<?php

namespace App\Http\Controllers;
use App\Models\Fournisseur;

use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        $products = collect();
        $total_products = 0;
        if (auth()->check()) {
            $fournisseur = Fournisseur::find(auth()->id());
            if ($fournisseur) {
                $products = $fournisseur->produits;
                $total_products = $fournisseur->produits->count();
            }
        }
        return view('fournisseur.dashboard', compact('products', 'total_products'));
    }

    public function create()
    {
        return view('fournisseur.create');
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
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
}
