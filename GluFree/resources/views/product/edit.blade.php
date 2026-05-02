@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumbs & Header -->
        <nav class="mb-8 flex items-center gap-2 text-sm font-medium text-stone-500">
            <a href="{{ route('product.index') }}" class="hover:text-forest transition">Catalogue</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-forest font-bold">Modifier le produit</span>
        </nav>

        <div class="mb-12">
            <h1 class="font-serif text-5xl font-extrabold text-forest mb-4">Mettre à Jour <br><span class="text-emerald-700 italic">le Produit</span></h1>
            <p class="text-stone-500 text-lg max-w-xl">Ajustez les détails de votre produit. Les modifications seront visibles immédiatement après l'enregistrement.</p>
        </div>

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')

            <!-- Main Information Card -->
            <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-xl shadow-stone-200/50 border border-stone-100 transition-all hover:shadow-2xl">
                <div class="flex items-center gap-4 mb-10 pb-6 border-b border-stone-50">
                    <div class="w-12 h-12 bg-forest/5 rounded-2xl flex items-center justify-center text-forest">
                        <i class="fa-solid fa-pen-to-square text-xl"></i>
                    </div>
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-forest">Informations Générales</h2>
                        <p class="text-stone-400 text-sm italic">Modifiez les caractéristiques du produit</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="name" class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 ml-1">Nom du Produit</label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $product->name) }}"
                            class="w-full bg-stone-50 border-none rounded-2xl px-6 py-4 text-forest placeholder:text-stone-300 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none font-medium @error('name') ring-2 ring-red-500/50 @enderror">
                        @error('name')
                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="category_id" class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 ml-1">Catégorie</label>
                        <div class="relative">
                            <select name="category_id" id="category_id" required 
                                class="w-full bg-stone-50 border-none rounded-2xl px-6 py-4 text-forest appearance-none focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none font-medium @error('category_id') ring-2 ring-red-500/50 @enderror">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-stone-300 pointer-events-none text-xs"></i>
                        </div>
                        @error('category_id')
                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="lg:col-span-2 space-y-2">
                        <label for="description" class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 ml-1">Description</label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full bg-stone-50 border-none rounded-2xl px-6 py-4 text-forest placeholder:text-stone-300 focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none font-medium resize-none @error('description') ring-2 ring-red-500/50 @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- media et certif carte-->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl p-8 shadow-xl shadow-stone-200/50 border border-stone-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-forest/5 rounded-xl flex items-center justify-center text-forest">
                            <i class="fa-solid fa-image text-lg"></i>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-forest">Visuel Produit</h3>
                    </div>

                    <div class="relative group">
                        <div class="w-full h-48 border-2 border-dashed border-stone-200 rounded-2xl flex flex-col items-center justify-center bg-stone-50 group-hover:bg-stone-100 transition-colors cursor-pointer overflow-hidden p-4">
                            <div id="preview-container" class="{{ $product->photo ? '' : 'hidden' }} w-full h-full">
                                <img id="image-preview" src="{{ $product->photo ? asset('storage/' . $product->photo) : '#' }}" alt="Preview" class="w-full h-full object-contain">
                            </div>
                            <div id="upload-placeholder" class="{{ $product->photo ? 'hidden' : '' }} text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-stone-300 mb-2"></i>
                                <p class="text-stone-400 text-xs font-bold uppercase tracking-widest">Modifier la photo</p>
                            </div>
                            <input type="file" name="photo" id="photo" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this)">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-xl shadow-stone-200/50 border border-stone-100 flex flex-col">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-forest/5 rounded-xl flex items-center justify-center text-forest">
                            <i class="fa-solid fa-certificate text-lg"></i>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-forest">Certifications</h3>
                    </div>
                    
                    <div class="flex-1 flex flex-col justify-center gap-6">
                        <div class="space-y-3">
                            <label for="certificationSansGluten" class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 ml-1">Sans Gluten Certifié ?</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="certificationSansGluten" id="certificationSansGluten" value="1" class="sr-only peer" {{ $product->certificationSansGluten ? 'checked' : '' }}>
                                <div class="w-14 h-8 bg-stone-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600"></div>
                                <span class="ms-3 text-sm font-bold text-stone-500">Activer le badge 100% sans gluten</span>
                            </label>
                        </div>
                        <p class="text-[10px] text-stone-400 leading-relaxed italic">
                            <i class="fa-solid fa-circle-info mr-1"></i> En activant cette certification, vous confirmez que votre produit a été testé pour les traces de gluten.
                        </p>
                    </div>
                </div>
            </div>

            <!-- (fournisseur seulement) -->
            @auth
            @php
                $myPivot = $product->fournisseurs()->where('fournisseur_id', auth()->id())->first()?->pivot;
            @endphp
            @if(auth()->user()->role === 'fournisseur')
            <div class="bg-forest rounded-3xl p-8 lg:p-12 shadow-2xl shadow-emerald-900/20 text-white">
                <div class="flex items-center gap-4 mb-10 pb-6 border-b border-white/10">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-emerald-400">
                        <i class="fa-solid fa-tags text-xl"></i>
                    </div>
                    <div>
                        <h2 class="font-serif text-2xl font-bold">Prix & Stock Personnels</h2>
                        <p class="text-emerald-100/60 text-sm italic">Mettez à jour vos conditions de vente pour ce produit</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="price" class="block text-[11px] font-bold uppercase tracking-widest text-emerald-100/40 ml-1">Prix de Vente (DH)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="price" id="price" required value="{{ old('price', $myPivot?->prix ?? 0) }}" 
                                class="w-full bg-white/5 border-none rounded-2xl px-6 py-4 text-white placeholder:text-emerald-100/20 focus:ring-2 focus:ring-white/20 transition-all outline-none font-medium @error('price') ring-2 ring-red-500/50 @enderror">
                            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-emerald-100/40 font-bold">DH</span>
                        </div>
                        @error('price')
                            <p class="text-red-200 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="quantitéStock" class="block text-[11px] font-bold uppercase tracking-widest text-emerald-100/40 ml-1">Quantité en Stock</label>
                        <input type="number" name="quantitéStock" id="quantitéStock" required value="{{ old('quantitéStock', $myPivot?->qteStock ?? 0) }}"
                            class="w-full bg-white/5 border-none rounded-2xl px-6 py-4 text-white placeholder:text-emerald-100/20 focus:ring-2 focus:ring-white/20 transition-all outline-none font-medium @error('quantitéStock') ring-2 ring-red-500/50 @enderror">
                        @error('quantitéStock')
                            <p class="text-red-200 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endif
            @endauth

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-6">
                <a href="{{ route('product.index') }}" class="text-stone-400 hover:text-forest font-bold uppercase tracking-widest text-[11px] transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
                </a>
                
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none bg-emerald-600 text-white px-12 py-5 rounded-2xl font-bold uppercase tracking-widest text-xs shadow-xl shadow-emerald-900/20 hover:bg-emerald-700 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        const placeholder = document.getElementById('upload-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
