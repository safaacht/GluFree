@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
            <div>
                <span class="text-emerald-700 font-bold uppercase tracking-[0.2em] text-[10px] mb-1 block">Espace Fournisseur</span>
                <h1 class="text-4xl font-extrabold text-forest font-serif">Commandes reçues</h1>
            </div>
            <a href="{{ route('fournisseur.index') }}"
               class="text-stone-400 hover:text-forest font-bold uppercase tracking-widest text-[11px] transition-colors flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Tableau de bord
            </a>
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
                                <p class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">
                                    Commande N°{{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}
                                </p>
                                <p class="text-sm font-medium text-forest">
                                    Reçue le {{ $commande->created_at->format('d/m/Y à H:i') }}
                                </p>
                                <p class="text-xs text-stone-400 mt-1">
                                    <i class="fa-regular fa-user mr-1"></i>
                                    Client : <span class="font-semibold text-forest">{{ $commande->user->name ?? 'Inconnu' }}</span>
                                </p>
                            </div>

                            <div class="flex items-center gap-6">
                                <div>
                                    @if($commande->status === 'en attente')
                                        <span class="bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2">
                                            <i class="fa-solid fa-clock"></i> En attente
                                        </span>
                                    @elseif($commande->status === 'livrée')
                                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2">
                                            <i class="fa-solid fa-check-double"></i> Livrée
                                        </span>
                                    @elseif($commande->status === 'annulée')
                                        <span class="bg-red-100 text-red-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2">
                                            <i class="fa-solid fa-xmark"></i> Annulée
                                        </span>
                                    @else
                                        <span class="bg-stone-100 text-stone-500 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full flex items-center gap-2">
                                            <i class="fa-solid fa-circle-dot"></i> {{ ucfirst($commande->status) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- accept button -->
                                @if($commande->status !== 'livrée' && $commande->status !== 'annulée')
                                    <form action="{{ route('commande.accepter', $commande->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            onclick="return confirm('Confirmer la livraison de cette commande ?')"
                                            class="bg-forest text-white text-xs font-bold uppercase tracking-widest px-5 py-2.5 rounded-full shadow hover:bg-emerald-800 active:scale-95 transition-all flex items-center gap-2">
                                            <i class="fa-solid fa-truck"></i> Accepter & Livrer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <h4 class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-4">
                                Articles commandés (vos produits)
                            </h4>
                            <div class="space-y-4">
                                @foreach($commande->items as $inventoryItem)
                                    @php
                                        $product = $inventoryItem->product;
                                        $pivot   = $inventoryItem->pivot;
                                    @endphp
                                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 hover:bg-stone-100 transition-colors">
                                        <div class="h-16 w-16 bg-white rounded-xl flex items-center justify-center p-1 flex-shrink-0 shadow-sm">
                                            @if($product && $product->photo)
                                                <img src="{{ asset('storage/' . $product->photo) }}"
                                                     alt="{{ $product->name }}"
                                                     class="h-full w-full object-contain">
                                            @else
                                                <i class="fa-solid fa-cookie-bite text-xl text-stone-300"></i>
                                            @endif
                                        </div>

                                        <!-- product info -->
                                        <div class="flex-grow">
                                            <h5 class="text-sm font-bold text-forest">
                                                {{ $product ? $product->name : 'Produit introuvable' }}
                                            </h5>
                                            <p class="text-xs text-stone-400 font-medium">
                                                Prix unitaire : {{ number_format($inventoryItem->prix, 2) }} DH
                                            </p>
                                        </div>

                                        <div class="text-center px-4">
                                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Qté</p>
                                            <p class="text-sm font-bold text-forest">{{ $pivot->qte }}</p>
                                        </div>

                                        <div class="text-right pl-4 border-l border-stone-200">
                                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Total</p>
                                            <p class="text-sm font-extrabold text-forest">
                                                {{ number_format($pivot->total_commande, 2) }} DH
                                            </p>
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
                    <i class="fa-solid fa-inbox text-4xl text-stone-300"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-forest mb-2">Aucune commande reçue</h2>
                    <p class="text-stone-500 max-w-md mx-auto">
                        Quand un client commandera l'un de vos produits, la commande apparaîtra ici.
                    </p>
                </div>
                <a href="{{ route('fournisseur.index') }}"
                   class="mt-4 bg-white text-forest border-2 border-forest py-3 px-8 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-forest hover:text-white transition-all duration-300">
                    Retour au tableau de bord
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
