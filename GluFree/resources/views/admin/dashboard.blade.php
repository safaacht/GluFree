@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-10 py-16">
    
    <div class="mb-12">
        <span class="text-emerald-700 font-bold uppercase tracking-[0.2em] text-[10px] mb-2 block">Pilotage de la plateforme</span>
        <h1 class="font-serif text-4xl text-forest italic leading-tight">Tableau de Bord Administratif</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        
        <div class="bg-forest p-8 rounded-[2.5rem] text-white shadow-xl shadow-emerald-900/10">
            <span class="text-emerald-200/50 text-[10px] uppercase tracking-widest font-bold block mb-2 italic">Communauté Totale</span>
            <p class="text-4xl font-serif italic">{{ $stats['total_users'] }}</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-emerald-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 opacity-5 group-hover:scale-110 transition-transform duration-700">
                <i class="fa-solid fa-store text-8xl text-forest"></i>
            </div>
            <span class="text-stone-400 text-[10px] uppercase tracking-widest font-bold block mb-2 italic">Partenaires Pros</span>
            <p class="text-4xl font-serif text-emerald-800">{{ $stats['total_fournisseurs'] }}</p>
            <span class="text-[9px] text-emerald-600 font-bold tracking-widest uppercase mt-2 block italic">Fournisseurs actifs</span>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-stone-100 shadow-sm hover:shadow-md transition">
            <span class="text-stone-400 text-[10px] uppercase tracking-widest font-bold block mb-2 italic">Catalogue Global</span>
            <p class="text-4xl font-serif text-forest">{{ $stats['total_products'] }}</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-stone-100 shadow-sm hover:shadow-md transition">
            <span class="text-stone-400 text-[10px] uppercase tracking-widest font-bold block mb-2 italic">Rayons / Catégories</span>
            <p class="text-4xl font-serif text-forest">{{ $stats['total_categories'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        </div>
</div>
@endsection