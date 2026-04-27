@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-10 py-16">
    <div class="flex justify-between items-end mb-12">
        <div>
            <span class="text-emerald-700 font-bold uppercase tracking-[0.2em] text-[10px] mb-2 block">Ma Boutique</span>
            <h1 class="font-serif text-4xl text-forest italic">Espace Fournisseur</h1>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('fournisseur.commandes') }}" class="border-2 border-forest text-forest px-6 py-3 rounded-full font-bold uppercase tracking-widest text-[10px] hover:bg-forest hover:text-white transition-all flex items-center gap-2">
                <i class="fa-solid fa-inbox"></i> Commandes reçues
            </a>
            @if(auth()->user()->status === 'accepté')
                <a href="{{ route('product.create') }}" class="bg-forest text-white px-8 py-3 rounded-full font-bold uppercase tracking-widest text-[10px] shadow-lg hover:bg-emerald-900 transition-all">
                    + Nouveau Produit
                </a>
            @else
                <span title="Votre compte doit être approuvé pour ajouter des produits" class="bg-stone-300 text-white px-8 py-3 rounded-full font-bold uppercase tracking-widest text-[10px] shadow-sm cursor-not-allowed opacity-70">
                    + Nouveau Produit
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white p-8 rounded-[2rem] border border-stone-100 shadow-sm">
            <span class="text-stone-400 text-[10px] uppercase tracking-widest font-bold block mb-2 italic">Mes articles</span>
            <p class="text-4xl font-serif text-forest tracking-tighter">{{ $total_products }}<span class="text-sm font-sans text-stone-300">en ligne</span></p>
        </div>
        <div class="bg-white p-8 rounded-[2rem] border border-stone-100 shadow-sm">
            <span class="text-stone-400 text-[10px] uppercase tracking-widest font-bold block mb-2 italic">Chiffre d'affaires</span>
            <p class="text-4xl font-serif text-forest tracking-tighter"> <span class="text-sm font-sans text-stone-300">DH</span></p>
        </div>
        <div class="bg-emerald-50/30 p-8 rounded-[2rem] border border-emerald-100 shadow-sm">
            <span class="text-emerald-700 text-[10px] uppercase tracking-widest font-bold block mb-2 italic">Statut Boutique</span>
            <p class="text-xl font-bold text-emerald-800 uppercase tracking-tighter italic">Ouverte</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-stone-100 shadow-sm overflow-hidden">
        <div class="px-10 py-6 border-b border-stone-50 flex justify-between items-center">
            <h3 class="font-serif text-xl text-forest italic">Mes Produits</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-stone-50/50 border-b border-stone-100 text-stone-400 text-[10px] uppercase tracking-[0.2em]">
                    <th class="px-10 py-6">Désignation</th>
                    <th class="px-10 py-6">Prix Unit.</th>
                    <th class="px-10 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-stone-600">
                @foreach($products as $product)
                <tr class="border-b border-stone-50 hover:bg-stone-50/30 transition">
                    <td class="px-10 py-6 font-serif text-forest text-lg">{{ $product->name }}</td>
                    <td class="px-10 py-6 font-bold text-forest">{{ $product->pivot->prix ?? '0' }} DH</td>
                    <td class="px-10 py-6 text-right space-x-4">
                        <a href="{{ route('product.edit', $product->id) }}" class="text-stone-300 hover:text-emerald-700 transition">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-stone-300 hover:text-red-400 transition" onclick="return confirm('Confirmer la suppression ?')">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection