@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-20 px-6">
    <div class="max-w-3xl w-full bg-white p-16 rounded-[3rem] shadow-sm border border-stone-100">
        <div class="mb-10">
            <a href="{{ route('fournisseur.dashboard') }}" class="text-stone-400 text-[10px] uppercase tracking-widest font-bold hover:text-forest transition">
                ← Retour au dashboard
            </a>
            <h2 class="font-serif text-4xl text-forest mt-4 italic">Modifier le Produit</h2>
        </div>

        <form action="{{ route('product.update', $product->id) }}" method="POST" class="space-y-8">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-3 ml-4">Nom du produit</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="w-full px-8 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10">
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-3 ml-4">Prix (€)</label>
                    <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full px-8 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-3 ml-4">Description</label>
                <textarea name="description" rows="4" class="w-full px-8 py-6 bg-stone-50 border-none rounded-[2rem] text-sm outline-none focus:ring-2 focus:ring-emerald-600/10">{{ $product->description }}</textarea>
            </div>

            <button class="w-full bg-forest text-white py-5 rounded-full font-bold uppercase tracking-[0.2em] text-[11px] shadow-2xl shadow-emerald-900/10 hover:bg-emerald-900 transition">
                Enregistrer les modifications
            </button>
        </form>
    </div>
</div>
@endsection