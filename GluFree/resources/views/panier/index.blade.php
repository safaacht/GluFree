@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-4 mb-10">
            <h1 class="text-4xl font-extrabold text-forest font-serif">Mon Panier</h1>
            <span class="bg-stone-200 text-stone-600 font-bold px-3 py-1 rounded-full text-sm">{{ count($cart) }} article(s)</span>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-100 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Shopping List -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $key => $item)
                        <div class="relative bg-white p-6 rounded-[2rem] shadow-sm border border-stone-100 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                            <!-- Image -->
                            <div class="h-24 w-24 bg-stone-50 rounded-2xl flex items-center justify-center flex-shrink-0 p-2">
                                @if($item['photo'])
                                    <img src="{{ asset('storage/' . $item['photo']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-contain">
                                @else
                                    <i class="fa-solid fa-cookie-bite text-3xl text-stone-300"></i>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="flex-grow pr-8 md:pr-0">
                                <h3 class="text-lg font-bold text-forest mb-1">{{ $item['name'] }}</h3>
                                <p class="text-sm font-medium text-stone-400 mb-2">Prix unitaire : {{ number_format($item['prix'], 2) }} DH</p>

                                <div class="flex items-center gap-3">
                                    <form action="{{ route('panier.update', $key) }}" method="POST" class="inline-flex items-center bg-stone-50 rounded-xl border border-stone-200 px-3 py-1.5 focus-within:ring-2 focus-within:ring-emerald-500/20">
                                        @csrf
                                        @method('PATCH')
                                        <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mr-2">QTE:</span>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['max_stock'] }}" 
                                            class="w-14 text-center bg-transparent border-none focus:ring-0 text-sm font-bold text-forest p-0 m-0" 
                                            onchange="this.form.submit()">
                                    </form>
                                    <span class="text-[10px] font-bold {{ $item['max_stock'] < 5 ? 'text-amber-500 bg-amber-50' : 'text-stone-400 bg-stone-50' }} px-2 py-1 flex items-center rounded border {{ $item['max_stock'] < 5 ? 'border-amber-100' : 'border-stone-100' }}">
                                        Max: {{ $item['max_stock'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Subtotal & Actions -->
                            <div class="text-right sm:border-l border-stone-100 sm:pl-6 flex flex-col justify-between items-end h-full">
                                <form action="{{ route('panier.remove', $key) }}" method="POST" class="absolute top-4 right-4 sm:static sm:mb-2 text-right w-full flex justify-end">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-stone-50 flex items-center justify-center text-stone-400 hover:text-red-500 hover:bg-red-50 transition-all border border-stone-100" title="Retirer du panier">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                                
                                <div class="mt-auto">
                                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-0.5">Sous-total</p>
                                    <p class="text-xl font-extrabold text-forest">{{ number_format($item['prix'] * $item['quantity'], 2) }} DH</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-8 rounded-[2rem] shadow-lg shadow-stone-200/50 border border-stone-100 sticky top-32">
                        <h2 class="text-xl font-bold text-forest mb-6">Récapitulatif</h2>
                        
                        <div class="space-y-4 text-sm font-medium text-stone-500 mb-6 border-b border-stone-100 pb-6">
                            <div class="flex justify-between">
                                <span>Sous-total articles</span>
                                <span class="text-black">{{ number_format($total, 2) }} DH</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Livraison estimate</span>
                                <span class="text-emerald-600 font-bold">Gratuite</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end mb-8">
                            <span class="text-sm font-bold text-stone-500 uppercase tracking-widest">Total</span>
                            <span class="text-3xl font-extrabold text-forest">{{ number_format($total, 2) }} DH</span>
                        </div>

                        <form action="{{ route('commande.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-forest text-white py-4 px-6 rounded-2xl font-bold uppercase tracking-widest text-xs flex items-center justify-center gap-3 shadow-xl shadow-forest/20 hover:bg-emerald-900 transition-all hover:-translate-y-1 active:scale-95">
                                <i class="fa-solid fa-check"></i>
                                Passer la commande
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white p-16 rounded-[2rem] shadow-sm border border-stone-100 flex flex-col items-center justify-center space-y-6 text-center">
                <div class="h-24 w-24 bg-stone-50 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-cart-arrow-down text-4xl text-stone-300"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-forest mb-2">Votre panier est vide</h2>
                    <p class="text-stone-500 max-w-md mx-auto">Parcourez notre catalogue et découvrez nos délicieux produits sans gluten pour garnir votre panier.</p>
                </div>
                <a href="{{ route('product.index') }}" class="mt-4 bg-white text-forest border-2 border-forest py-3 px-8 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-forest hover:text-white transition-all duration-300">
                    Découvrir les produits
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
