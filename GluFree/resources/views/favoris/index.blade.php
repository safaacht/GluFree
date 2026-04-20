@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12 border-b border-stone-200 pb-8">
            <h1 class="font-serif text-5xl font-extrabold text-forest mb-4 leading-tight">Mes <span class="text-emerald-700 italic">Favoris</span></h1>
            <p class="text-stone-500 text-lg max-w-2xl font-medium">Retrouvez ici tous les produits que vous avez aimés.</p>
        </div>

        @if($favoris->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($favoris as $product)
                    <div class="group relative bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-forest/10 transition-all duration-500 border border-stone-100 flex flex-col h-full transform hover:-translate-y-1">
                        
                        <!-- Remove from Favoris -->
                        <form action="{{ route('favoris.destroy', $product->id) }}" method="POST" class="absolute top-4 right-4 z-20">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 bg-white/90 text-red-500 rounded-full flex items-center justify-center shadow-md backdrop-blur-md transition-colors" title="Retirer des favoris">
                                <i class="fa-solid fa-heart text-lg"></i>
                            </button>
                        </form>

                        <!-- Image Container -->
                        <div class="relative h-64 overflow-hidden bg-stone-50 flex items-center justify-center p-6">
                            @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full bg-stone-200 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                                    <i class="fa-solid fa-cookie-bite text-5xl text-stone-300"></i>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                <span class="bg-forest text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-md">
                                    {{ $product->category->name ?? 'Général' }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="font-serif text-xl font-bold text-forest mb-2 line-clamp-1 group-hover:text-emerald-700 transition-colors">{{ $product->name }}</h3>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-stone-100">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-1">Prix Unitaire</span>
                                    @php $prix = $product->fournisseurs->first()?->pivot?->prix; @endphp
                                    <span class="font-bold text-2xl text-forest">
                                        {{ $prix ? number_format($prix, 2) : '-' }}<span class="text-sm text-stone-500 ml-1">DH</span>
                                    </span>
                                </div>
                                
                                <form action="{{'#' }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-12 h-12 bg-forest text-white rounded-2xl flex items-center justify-center hover:bg-emerald-800 transition-all hover:shadow-lg hover:shadow-emerald-900/20 group/btn transform hover:scale-105 active:scale-95" title="Ajouter au panier">
                                        <i class="fa-solid fa-plus text-lg group-hover/btn:rotate-90 transition-transform duration-300"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-16 text-center border border-stone-200 shadow-sm mt-8 flex flex-col justify-center items-center min-h-[400px]">
                <div class="w-32 h-32 bg-stone-50 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-regular fa-heart text-4xl text-stone-300"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-forest mb-3">Votre liste est vide</h3>
                <p class="text-stone-500 max-w-md mx-auto mb-8">Vous n'avez pas encore ajouté de produits à vos favoris.</p>
                <a href="{{ route('product.index') }}" class="btn-elegant text-white px-8 py-3 rounded-full font-bold uppercase tracking-widest text-xs shadow-lg shadow-emerald-900/10 inline-block">
                    Parcourir le catalogue
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
