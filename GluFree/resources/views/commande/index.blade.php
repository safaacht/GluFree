@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-4 mb-10">
            <h1 class="text-4xl font-extrabold text-forest font-serif">Mes Commandes</h1>
            <span class="bg-stone-200 text-stone-600 font-bold px-3 py-1 rounded-full text-sm">{{ $commandes->count() }} commande(s)</span>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @if($commandes->count() > 0)
            <div class="space-y-8">
                @foreach($commandes as $commande)
                    <div class="bg-white rounded-[2rem] shadow-sm border border-stone-100 overflow-hidden">
                        
                        <div class="bg-stone-50 border-b border-stone-100 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <p class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Commande N°{{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-sm font-medium text-forest">Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            
                            <div class="flex items-center gap-6">
                                <div class="text-right">
                                    <p class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Total</p>
                                    <p class="text-xl font-extrabold text-forest">{{ number_format($commande->total_general, 2) }} DH</p>
                                </div>
                                <div class="h-10 w-px bg-stone-200"></div>
                                <div>
                                    @if($commande->status === 'en attente')
                                        <span class="bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2"><i class="fa-solid fa-clock"></i> En traitement</span>
                                    @elseif($commande->status === 'payée')
                                        <span class="bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2"><i class="fa-solid fa-credit-card"></i> Payée</span>
                                    @elseif($commande->status === 'expédiée')
                                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2"><i class="fa-solid fa-truck"></i> Expédiée</span>
                                    @elseif($commande->status === 'livrée')
                                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2"><i class="fa-solid fa-check-double"></i> Livrée</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2"><i class="fa-solid fa-xmark"></i> Annulée</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Order items -->
                        <div class="p-6">
                            <h4 class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-4">Articles achetés</h4>
                            <div class="space-y-4">
                                @foreach($commande->items as $inventoryItem)
                                    @php
                                        $product = $inventoryItem->product; 
                                        $pivot = $inventoryItem->pivot;
                                    @endphp
                                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 hover:bg-stone-100 transition-colors">
                                        <div class="h-16 w-16 bg-white rounded-xl flex items-center justify-center p-1 flex-shrink-0 shadow-sm">
                                            @if($product && $product->photo)
                                                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="h-full w-full object-contain">
                                            @else
                                                <i class="fa-solid fa-cookie-bite text-xl text-stone-300"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <h5 class="text-sm font-bold text-forest">{{ $product ? $product->name : 'Produit introuvable' }}</h5>
                                            <p class="text-xs text-stone-400 font-medium">Vendu par : {{ $inventoryItem->fournisseur->name ?? 'Inconnu' }}</p>
                                        </div>
                                        <div class="text-center px-4">
                                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">QTE</p>
                                            <p class="text-sm font-bold text-forest">{{ $pivot->qte }}</p>
                                        </div>
                                        <div class="text-right pl-4 border-l border-stone-200">
                                            <p class="text-sm font-extrabold text-forest">{{ number_format($pivot->total_commande, 2) }} DH</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-16 rounded-[2rem] shadow-sm border border-stone-100 flex flex-col items-center justify-center space-y-6 text-center">
                <div class="h-24 w-24 bg-stone-50 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-box-open text-4xl text-stone-300"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-forest mb-2">Aucune commande pour le moment</h2>
                    <p class="text-stone-500 max-w-md mx-auto">Vous n'avez pas encore passé de commande. Découvrez notre catalogue pour vous faire plaisir !</p>
                </div>
                <a href="{{ route('product.index') }}" class="mt-4 bg-white text-forest border-2 border-forest py-3 px-8 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-forest hover:text-white transition-all duration-300">
                    Découvrir les produits
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
