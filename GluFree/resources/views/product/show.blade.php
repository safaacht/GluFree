@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumbs & Actions -->
        <div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <nav class="flex items-center gap-2 text-sm font-medium text-stone-500">
                <a href="{{ route('product.index') }}" class="hover:text-forest transition">Catalogue</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-forest font-bold">{{ $product->name }}</span>
            </nav>

            <div class="flex items-center gap-4">
                @if(!auth()->check())
                    <a href="{{ route('login') }}" class="w-10 h-10 bg-white text-stone-400 hover:text-red-500 rounded-xl flex items-center justify-center border border-stone-200 shadow-sm transition-all" title="Connectez-vous pour ajouter aux favoris">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                @elseif(!in_array(auth()->user()->role, ['admin', 'fournisseur']))
                    @php
                        $isFavoris = auth()->user()->favoris->contains($product->id);
                    @endphp
                    @if($isFavoris)
                        <form action="{{ route('favoris.destroy', $product->id) }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 bg-white text-red-500 rounded-xl flex items-center justify-center border border-stone-200 shadow-sm transition-all">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favoris.store', $product->id) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-10 h-10 bg-white text-stone-400 hover:text-red-500 rounded-xl flex items-center justify-center border border-stone-200 shadow-sm transition-all">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </form>
                    @endif
                @endif
                @if(auth()->user() && (auth()->user()->role === 'admin' || (auth()->user()->role === 'fournisseur' && auth()->user()->status === 'accepté')))
                    <a href="{{ route('product.edit', $product->id) }}" class="bg-white text-forest border border-stone-200 px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-stone-50 transition-all shadow-sm">
                        <i class="fa-solid fa-pen mr-2"></i> Modifier
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-12 xl:col-span-7">
                <div class="sticky top-32 space-y-8">
                    <div class="relative aspect-square sm:aspect-[4/3] lg:aspect-square bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-stone-200/50 border border-stone-100 flex items-center justify-center p-12 lg:p-20">
                        @if($product->photo)
                            <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                        @else
                            <div class="w-full h-full bg-stone-50 rounded-3xl flex items-center justify-center">
                                <i class="fa-solid fa-cookie-bite text-9xl text-stone-200"></i>
                            </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-8 left-8 flex flex-col gap-3">
                            <span class="bg-forest text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full shadow-lg backdrop-blur-md">
                                {{ $product->category->name ?? 'Général' }}
                            </span>
                            @if($product->certificationSansGluten)
                                <span class="bg-white/90 text-emerald-700 text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full shadow-lg backdrop-blur-md flex items-center gap-2 border border-emerald-100">
                                    <i class="fa-solid fa-certificate"></i> Certifié 100% Sans Gluten
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- details -->
            <div class="lg:col-span-12 xl:col-span-5 flex flex-col space-y-10">
                <div class="space-y-6">
                    <h1 class="font-serif text-5xl lg:text-6xl font-extrabold text-forest leading-tight">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex text-amber-400">
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-regular fa-star text-xs text-stone-300"></i>
                        </div>
                        <span class="text-stone-400 text-xs font-bold uppercase tracking-widest">(12 avis clients)</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-[11px] font-bold uppercase tracking-widest text-stone-400">Le Mot du Producteur</h3>
                    <p class="text-stone-500 text-lg leading-relaxed font-medium">
                        {{ $product->description ?? 'Aucune description détaillée n\'est encore disponible pour ce produit d\'exception.' }}
                    </p>
                </div>

                @php 
                    $firstFournisseur = $product->fournisseurs->first();
                    $prix = $firstFournisseur ? $firstFournisseur->pivot->prix : 0;
                    $stock = $firstFournisseur ? $firstFournisseur->pivot->qteStock : null;
                @endphp

                @if(!auth()->check())
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full">
                    <div class="flex items-center bg-white border border-stone-200 rounded-2xl p-2 w-full sm:w-auto self-stretch opacity-50 pointer-events-none">
                        <button type="button" class="w-10 h-10 flex items-center justify-center text-stone-400"><i class="fa-solid fa-minus"></i></button>
                        <input type="number" value="1" class="w-16 text-center bg-transparent border-none font-bold text-forest" disabled>
                        <button type="button" class="w-10 h-10 flex items-center justify-center text-stone-400"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    
                    <a href="{{ route('login') }}" class="w-full bg-forest text-white py-4 px-8 rounded-2xl font-bold uppercase tracking-widest text-xs flex items-center justify-center gap-3 shadow-xl shadow-forest/20 hover:bg-emerald-900 transition-all hover:-translate-y-1 active:scale-95" title="Connectez-vous pour ajouter au panier">
                        <i class="fa-solid fa-cart-shopping"></i> Se connecter pour acheter
                    </a>
                </div>
                @else
                <form action="{{ route('panier.add', $product->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4 w-full">
                    @csrf
                    @if($firstFournisseur)
                        <input type="hidden" name="fournisseur_id" value="{{ $firstFournisseur->id }}">
                        <input type="hidden" name="prix" value="{{ $prix }}">
                    @endif
                    
                
                    
                    <button type="submit" class="w-full bg-forest text-white py-4 px-8 rounded-2xl font-bold uppercase tracking-widest text-xs flex items-center justify-center gap-3 shadow-xl shadow-forest/20 hover:bg-emerald-900 transition-all hover:-translate-y-1 active:scale-95" {{ (!is_null($stock) && $stock <= 0) ? 'disabled' : '' }}>
                        <i class="fa-solid fa-cart-shopping"></i> Ajouter au Panier
                    </button>
                </form>
                @endif

                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="flex items-center gap-3 p-4 bg-stone-50 rounded-2xl border border-stone-100">
                        <i class="fa-solid fa-truck text-emerald-600"></i>
                        <span class="text-[10px] font-bold text-stone-500 uppercase tracking-wide">Livraison Express</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-stone-50 rounded-2xl border border-stone-100">
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                        <span class="text-[10px] font-bold text-stone-500 uppercase tracking-wide">Paiement a la livraison</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
