@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header: Fournisseur Info -->
        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-stone-100 mb-12 flex flex-col md:flex-row items-center gap-8">
            <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-store text-5xl text-emerald-700"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <span class="text-emerald-700 font-bold uppercase tracking-[0.2em] text-[10px] mb-2 block">Fournisseur Partenaire</span>
                <h1 class="font-serif text-4xl text-forest font-bold mb-4">{{ $fournisseur->name }}</h1>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 text-stone-500">
                    @if($fournisseur->tel)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-emerald-700"></i>
                        <a href="tel:{{ $fournisseur->tel }}" class="hover:text-emerald-700 transition">{{ $fournisseur->tel }}</a>
                    </div>
                    @endif
                    
                    @if($fournisseur->email)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-emerald-700"></i>
                        <a href="mailto:{{ $fournisseur->email }}" class="hover:text-emerald-700 transition">{{ $fournisseur->email }}</a>
                    </div>
                    @endif
                    
                    @if($fournisseur->city)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-emerald-700"></i>
                        <span>{{ $fournisseur->city->name }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fournisseur's Products -->
        <div class="mb-8 border-b border-stone-200 pb-4">
            <h2 class="font-serif text-3xl font-extrabold text-forest">Produits publiés par <span class="text-emerald-700 italic">{{ $fournisseur->name }}</span></h2>
        </div>

        @php
            $products = $fournisseur->produits; // lazy loading
        @endphp

        @if($products && $products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="group relative bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-forest/10 transition-all duration-500 border border-stone-100 flex flex-col h-full transform hover:-translate-y-1">
                        
                        <!-- Image Container (Clickable) -->
                        <a href="{{ route('product.show', $product->id) }}" class="relative h-64 overflow-hidden bg-stone-50 flex items-center justify-center p-6 block">
                            @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full bg-stone-200 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                                    <i class="fa-solid fa-cookie-bite text-5xl text-stone-300"></i>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                <span class="bg-forest text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-md backdrop-blur-md">
                                    {{ $product->category->name ?? 'Général' }}
                                </span>
                            </div>
                            
                            <!-- Hover Overlay for "More Info" -->
                            <div class="absolute inset-0 bg-forest/0 group-hover:bg-forest/10 transition-colors duration-300 flex items-center justify-center">
                                <span class="bg-white text-forest px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg transform translate-y-4 group-hover:translate-y-0">
                                    <i class="fa-solid fa-eye mr-2"></i>Voir détails
                                </span>
                            </div>
                        </a>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <!-- Stock Status Indicator -->
                            <div class="flex items-center gap-2 mb-3">
                            @php
                                $stock = $product->pivot->qteStock ?? null;
                            @endphp
                            @if(!is_null($stock) && $stock > 10)
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-xs font-semibold text-emerald-700">En Stock ({{ $stock }})</span>
                            @elseif(!is_null($stock) && $stock > 0)
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                <span class="text-xs font-semibold text-amber-700">Stock Limité ({{ $stock }})</span>
                            @elseif(!is_null($stock))
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                <span class="text-xs font-semibold text-red-700">Rupture de stock</span>
                            @else
                                <span class="w-2 h-2 rounded-full bg-stone-300"></span>
                                <span class="text-xs font-semibold text-stone-400">Stock non défini</span>
                            @endif
                            </div>

                            <a href="{{ route('product.show', $product->id) }}" class="block">
                                <h3 class="font-serif text-xl font-bold text-forest mb-2 line-clamp-1 group-hover:text-emerald-700 transition-colors">{{ $product->name }}</h3>
                            </a>
                            <p class="text-stone-500 text-sm line-clamp-2 mb-4 flex-1 leading-relaxed">{{ $product->description ?? 'Aucune description disponible.' }}</p>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-stone-100">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-1">Prix Unitaire</span>
                                    @php $prix = $product->pivot->prix ?? null; @endphp
                                    <span class="font-bold text-2xl text-forest">
                                        {{ $prix ? number_format($prix, 2) : '-' }}<span class="text-sm text-stone-500 ml-1">DH</span>
                                    </span>
                                </div>
                                <a href="{{ route('product.show', $product->id) }}" class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center hover:bg-emerald-700 hover:text-white transition-all hover:shadow-lg group/btn transform hover:scale-105 active:scale-95" title="Plus d'informations">
                                    <i class="fa-solid fa-circle-info text-xl transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-16 text-center border border-stone-200 shadow-sm mt-8 flex flex-col justify-center items-center min-h-[400px]">
                <div class="w-32 h-32 bg-stone-50 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-solid fa-box-open text-4xl text-stone-300"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-forest mb-3">Aucun produit</h3>
                <p class="text-stone-500 max-w-md mx-auto">Ce fournisseur n'a pas encore publié de produits.</p>
            </div>
        @endif
    </div>
</div>
@endsection
