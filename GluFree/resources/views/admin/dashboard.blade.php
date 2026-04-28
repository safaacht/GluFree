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
            <p class="text-4xl font-serif text-emerald-800">{{ $stats['total_Fournisseur'] }}</p>
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

    @if(session('success'))
        <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 text-[12px] font-semibold px-6 py-4 rounded-2xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

     {{-- Fournisseurs  --}}
    <div class="bg-white rounded-[2.5rem] border border-stone-100 shadow-sm overflow-hidden mb-10">
        <div class="px-10 py-6 border-b border-stone-50">
            <h3 class="font-serif text-xl text-forest italic">Fournisseurs &mdash; Validation</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-stone-50/50 border-b border-stone-100 text-stone-400 text-[10px] uppercase tracking-[0.2em]">
                    <th class="px-8 py-5">Nom</th>
                    <th class="px-8 py-5">Email</th>
                    <th class="px-8 py-5">Ville</th>
                    <th class="px-8 py-5">Statut</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-stone-600 text-sm">
                @forelse($fournisseurs as $f)
                <tr class="border-b border-stone-50 hover:bg-stone-50/30 transition">
                    <td class="px-8 py-5 font-serif text-forest">{{ $f->name }}</td>
                    <td class="px-8 py-5">{{ $f->email }}</td>
                    <td class="px-8 py-5">{{ $f->city?->name ?? '-' }}</td>
                    <td class="px-8 py-5">
                        @if($f->status === 'accepté')
                            <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full">Accepté</span>
                        @elseif($f->status === 'refusé')
                            <span class="bg-red-50 text-red-500 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full">Refusé</span>
                        @else
                            <span class="bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full">En attente</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right space-x-2">
                        @if($f->status !== 'accepté')
                        <form action="{{ route('admin.fournisseur.accept', $f) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full transition">
                                Accepter
                            </button>
                        </form>
                        @endif
                        @if($f->status !== 'refusé')
                        <form action="{{ route('admin.fournisseur.refuser', $f) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button class="bg-red-50 text-red-500 hover:bg-red-100 text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full transition">
                                Refuser
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-8 text-center text-stone-300 italic">Aucun fournisseur inscrit.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($fournisseurs->hasPages())
        <div class="px-10 py-6 border-t border-stone-50">
            {{ $fournisseurs->links() }}
        </div>
        @endif
    </div>

      {{-- Produits  --}}
    <div class="bg-white rounded-[2.5rem] border border-stone-100 shadow-sm overflow-hidden">
        <div class="px-10 py-6 border-b border-stone-50">
            <h3 class="font-serif text-xl text-forest italic">Produits &mdash; Gestion</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-stone-50/50 border-b border-stone-100 text-stone-400 text-[10px] uppercase tracking-[0.2em]">
                    <th class="px-8 py-5">Produit</th>
                    <th class="px-8 py-5">Catégorie</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-stone-600 text-sm">
                @forelse($products as $product)
                <tr class="border-b border-stone-50 hover:bg-stone-50/30 transition">
                    <td class="px-8 py-5 font-serif text-forest">{{ $product->name }}</td>
                    <td class="px-8 py-5">{{ $product->category?->name ?? '-' }}</td>
                    <td class="px-8 py-5 text-right">
                        <form action="{{ route('admin.product.delete', $product) }}" method="POST" class="inline"
                              onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-500 hover:bg-red-100 text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full transition">
                                <i class="fa-regular fa-trash-can mr-1"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-8 py-8 text-center text-stone-300 italic">Aucun produit disponible.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($products->hasPages())
        <div class="px-10 py-6 border-t border-stone-50">
            {{ $products->links() }}
        </div>
        @endif
    </div>

</div>
@endsection