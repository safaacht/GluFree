@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
                <!-- header and search section -->
        <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6 border-b border-stone-200 pb-8">
            <div class="text-center md:text-left flex-1">
                <h1 class="font-serif text-5xl font-extrabold text-forest mb-4 leading-tight">Découvrez Notre<br><span class="text-emerald-700 italic">Catalogue</span></h1>
                <p class="text-stone-500 text-lg max-w-2xl font-medium">Parcourez notre sélection rigoureuse de produits locaux certifiés 100% sans gluten. Mangez sainement, sans compromis sur le goût.</p>
            </div>

            <div class="flex flex-col gap-4 items-end w-full md:w-auto">
                @if(auth()->user() && (auth()->user()->role === 'admin' || (auth()->user()->role === 'fournisseur' && auth()->user()->status === 'accepté')))
                    <a href="{{ route('product.create') }}" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold hover:bg-primary-dark transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95 flex items-center gap-2 self-start md:self-end">
                        <span class="text-xl">+</span> Nouveau Produit
                    </a>
                @endif

                <!-- Filters & search -->
                <form method="GET" action="{{ route('product.index') }}" class="w-full flex flex-col sm:flex-row gap-4 items-center bg-white p-3 rounded-2xl shadow-xl shadow-stone-200/50 border border-stone-100">
                    <div class="relative w-full sm:w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 transform -translate-y-1/2 text-stone-400"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Chercher un produit..." class="w-full pl-11 pr-4 py-3 bg-stone-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-forest/20 outline-none transition-all placeholder:text-stone-400">
                    </div>
                    
                    <div class="relative w-full sm:w-48">
                        <select name="category" class="w-full pl-4 pr-10 py-3 bg-stone-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-forest/20 outline-none transition-all appearance-none text-stone-600">
                            <option value="">Toutes les catégories</option>
                            @if(isset($categories))
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ ($category ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-stone-400 text-xs pointer-events-none"></i>
                    </div>

                    <div class="relative w-full sm:w-48">
                        <select name="city" class="w-full pl-4 pr-10 py-3 bg-stone-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-forest/20 outline-none transition-all appearance-none text-stone-600">
                            <option value="">Toutes les villes</option>
                            @if(isset($cities))
                                @foreach($cities as $c)
                                    <option value="{{ $c->id }}" {{ (request('city') == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-stone-400 text-xs pointer-events-none"></i>
                    </div>

                    <button type="submit" class="w-full sm:w-auto bg-forest text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-emerald-900 transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 whitespace-nowrap">
                        Filtrer
                    </button>
                </form>
            </div>
        </div>

        @if(isset($products) && $products->count() > 0)
            <!-- Products grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="group relative bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-forest/10 transition-all duration-500 border border-stone-100 flex flex-col h-full transform hover:-translate-y-1">
                        
                       {{-- only for admin and fournisseur --}}
                        @if(auth()->user() && (auth()->user()->role === 'admin' || (auth()->user()->role === 'fournisseur' && auth()->user()->status === 'accepté')))
                        <div class="absolute top-4 right-4 z-20 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('product.edit', $product->id) }}" class="w-8 h-8 bg-white/90 text-stone-500 hover:text-blue-600 rounded-full flex items-center justify-center shadow-md backdrop-blur-md transition-colors" title="Modifier">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit?')" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 bg-white/90 text-stone-500 hover:text-red-600 rounded-full flex items-center justify-center shadow-md backdrop-blur-md transition-colors" title="Supprimer">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                        @endif

                        <!-- image container -->
                        <div class="relative h-64 overflow-hidden bg-stone-50 flex items-center justify-center p-6">
                            @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full bg-stone-200 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                                    <i class="fa-solid fa-cookie-bite text-5xl text-stone-300"></i>
                                </div>
                            @endif
                            
                            <!-- badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                <span class="bg-forest text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-md backdrop-blur-md">
                                    {{ $product->category->name ?? 'Général' }}
                                </span>
                                @if($product->certificationSansGluten)
                                    <span class="bg-white/90 text-emerald-700 text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-md backdrop-blur-md flex items-center gap-1">
                                        <i class="fa-solid fa-check-circle"></i> Certifié GluFree
                                    </span>
                                @endif
                            </div>

                            {{-- only client could favorise the product --}}
                            @if(!auth()->check())
                                <a href="{{ route('login') }}" class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-90 group-hover:scale-100 w-10 h-10 bg-white/90 text-stone-400 hover:text-red-500 rounded-full flex items-center justify-center shadow-lg backdrop-blur-md" title="Connectez-vous pour ajouter aux favoris">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            @elseif(!in_array(auth()->user()->role, ['admin', 'fournisseur']))
                                @php
                                    $isFavoris = auth()->user()->favoris->contains($product->id);
                                @endphp
                                @if($isFavoris)
                                    <form action="{{ route('favoris.destroy', $product->id) }}" method="POST" class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-90 group-hover:scale-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 bg-white/90 text-red-500 rounded-full flex items-center justify-center shadow-lg backdrop-blur-md">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('favoris.store', $product->id) }}" method="POST" class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-90 group-hover:scale-100">
                                        @csrf
                                        <button type="submit" class="w-10 h-10 bg-white/90 text-stone-400 hover:text-red-500 rounded-full flex items-center justify-center shadow-lg backdrop-blur-md">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>

                        <!-- content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 mb-3">
                                {{-- Get stock from pivot if available --}}
                            @php
                                $stock = $product->fournisseurs->first()?->pivot?->qteStock;
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

                            <h3 class="font-serif text-xl font-bold text-forest mb-1 line-clamp-1 group-hover:text-emerald-700 transition-colors">{{ $product->name }}</h3>
                            
                            @php $fournisseur = $product->fournisseurs->first(); @endphp
                            @if($fournisseur)
                                <a href="{{ route('fournisseur.show', $fournisseur->id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-stone-400 hover:text-emerald-600 transition-colors mb-3 group/store relative z-20">
                                    <i class="fa-solid fa-store group-hover/store:scale-110 transition-transform"></i> Par {{ $fournisseur->name }}
                                </a>
                            @endif

                            <p class="text-stone-500 text-sm line-clamp-2 mb-4 flex-1 leading-relaxed">{{ $product->description ?? 'Aucune description disponible.' }}</p>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-stone-100">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-1">Prix Unitaire</span>
                                    @php $prix = $product->fournisseurs->first()?->pivot?->prix; @endphp
                                    <span class="font-bold text-2xl text-forest">
                                        {{ $prix ? number_format($prix, 2) : '-' }}<span class="text-sm text-stone-500 ml-1">DH</span>
                                    </span>
                                </div>
                                
                                @if(!auth()->check())
                                    <a href="{{ route('login') }}" class="w-12 h-12 bg-forest text-white rounded-2xl flex items-center justify-center hover:bg-emerald-800 transition-all hover:shadow-lg hover:shadow-emerald-900/20 group/btn transform hover:scale-105 active:scale-95 disabled:bg-stone-300 disabled:cursor-not-allowed disabled:hover:scale-100" title="Connectez-vous pour ajouter au panier">
                                        <i class="fa-solid fa-plus text-lg group-hover/btn:rotate-90 transition-transform duration-300"></i>
                                    </a>
                                @else
                                    <form action="{{ route('panier.add', $product->id) }}" method="POST" class="m-0 flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="fournisseur_id" value="{{ $product->fournisseurs->first()?->id }}">
                                        <input type="hidden" name="prix" value="{{ $prix }}">
                                        <button type="submit" class="w-12 h-12 bg-forest text-white rounded-2xl flex items-center justify-center hover:bg-emerald-800 transition-all hover:shadow-lg hover:shadow-emerald-900/20 group/btn transform hover:scale-105 active:scale-95 disabled:bg-stone-300 disabled:cursor-not-allowed disabled:hover:scale-100" {{ (!is_null($stock) && $stock <= 0) ? 'disabled' : '' }} title="Ajouter au panier">
                                            <i class="fa-solid fa-plus text-lg group-hover/btn:rotate-90 transition-transform duration-300"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- pagination -->
            @if($products->hasPages())
                <div class="mt-16 flex justify-center">
                    <nav class="flex items-center gap-1">
                        <!-- previous -->
                        @if($products->onFirstPage())
                            <span class="px-4 py-2 rounded-xl text-stone-300 bg-white border border-stone-100 text-sm font-bold cursor-not-allowed select-none">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}"
                               class="px-4 py-2 rounded-xl text-forest bg-white border border-stone-100 text-sm font-bold hover:bg-emerald-50 hover:border-emerald-200 transition-colors shadow-sm">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        @endif

                        <!-- nbr pages -->
                        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if($page == $products->currentPage())
                                <span class="px-4 py-2 rounded-xl bg-forest text-white text-sm font-bold shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="px-4 py-2 rounded-xl text-forest bg-white border border-stone-100 text-sm font-bold hover:bg-emerald-50 hover:border-emerald-200 transition-colors shadow-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- next -->
                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}"
                               class="px-4 py-2 rounded-xl text-forest bg-white border border-stone-100 text-sm font-bold hover:bg-emerald-50 hover:border-emerald-200 transition-colors shadow-sm">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="px-4 py-2 rounded-xl text-stone-300 bg-white border border-stone-100 text-sm font-bold cursor-not-allowed select-none">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        @endif
                    </nav>
                </div>
            @endif

        @else
            <div class="bg-white rounded-3xl p-16 text-center border border-stone-200 shadow-sm mt-8 flex flex-col justify-center items-center min-h-[400px]">
                <div class="w-32 h-32 bg-stone-50 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-solid fa-basket-shopping text-4xl text-stone-300"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-forest mb-3">Aucun produit trouvé</h3>
                <p class="text-stone-500 max-w-md mx-auto mb-8">Nous n'avons trouvé aucun produit correspondant à vos critères dans le catalogue.</p>
                <a href="{{ route('product.index') }}" class="btn-elegant text-white px-8 py-3 rounded-full font-bold uppercase tracking-widest text-xs shadow-lg shadow-emerald-900/10 inline-block">
                    Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
