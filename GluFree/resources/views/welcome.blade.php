@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FCFBFA]">

    <div class="relative flex flex-col items-center justify-center py-32 text-center px-6 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full opacity-5 pointer-events-none">
            <i class="fa-solid fa-leaf text-[40rem] text-emerald-900 rotate-12"></i>
        </div>

        <div class="relative z-10">
            <span class="text-emerald-700 font-bold uppercase tracking-[0.3em] text-[11px] mb-6 block">L'excellence au naturel</span>
            
            <h1 class="font-serif text-5xl md:text-7xl text-forest mb-8 leading-[1.1]">
                Plateforme de Gestion <br> 
                <span class="italic text-emerald-800">Sans Gluten</span>
            </h1>

            <p class="text-stone-500 max-w-2xl mx-auto mb-12 text-lg font-light leading-relaxed">
                Une solution moderne et raffinée dédiée aux fournisseurs d'exception. 
                Gérez vos collections, suivez vos performances et cultivez votre succès en toute simplicité.
            </p>

            <div class="flex gap-6 flex-wrap justify-center">
                <a href="{{ route('product.index') }}"
                   class="bg-forest text-white px-10 py-4 rounded-full font-bold uppercase tracking-widest text-[11px] shadow-2xl shadow-emerald-900/20 hover:bg-emerald-900 transition-all duration-300">
                    Découvrir les Produits
                </a>

                @guest
                <a href="{{ route('register.create') }}"
                   class="border border-stone-200 text-forest px-10 py-4 rounded-full font-bold uppercase tracking-widest text-[11px] hover:bg-stone-50 transition-all">
                    Devenir Partenaire
                </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto pb-32 px-6">

        <div class="group bg-white p-10 rounded-[2.5rem] shadow-sm border border-stone-100 hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-500">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                <i class="fa-solid fa-sliders text-xl"></i>
            </div>
            <h3 class="font-serif text-2xl text-forest mb-4">Gestion Intuitive</h3>
            <p class="text-stone-500 text-sm leading-relaxed">Sublimez votre catalogue avec une interface pensée pour la précision et la fluidité.</p>
        </div>

        <div class="group bg-white p-10 rounded-[2.5rem] shadow-sm border border-stone-100 hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-500">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                <i class="fa-solid fa-chart-line text-xl"></i>
            </div>
            <h3 class="font-serif text-2xl text-forest mb-4">Analyse Visionnaire</h3>
            <p class="text-stone-500 text-sm leading-relaxed">Prenez des décisions éclairées grâce à un tableau de bord intelligent et détaillé.</p>
        </div>

        <div class="group bg-white p-10 rounded-[2.5rem] shadow-sm border border-stone-100 hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-500">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                <i class="fa-solid fa-award text-xl"></i>
            </div>
            <h3 class="font-serif text-2xl text-forest mb-4">Qualité Certifiée</h3>
            <p class="text-stone-500 text-sm leading-relaxed">Un écosystème exclusif garantissant l'intégrité et la pureté des produits sans gluten.</p>
        </div>

    </div>
</div>
@endsection