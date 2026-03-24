@extends('layouts.app')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-6">
    <div class="max-w-md w-full bg-white p-12 rounded-[3rem] shadow-sm border border-stone-100 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <i class="fa-solid fa-leaf text-6xl text-emerald-900"></i>
        </div>

        <div class="text-center mb-10 relative z-10">
            <span class="text-emerald-700 font-bold uppercase tracking-[0.2em] text-[10px] mb-3 block">Espace Membre</span>
            <h2 class="font-serif text-4xl text-forest mb-2 italic">Bon retour</h2>
            <p class="text-stone-400 text-sm font-light">Accédez à votre collection privée</p>
        </div>

        <form action="{{ route('login.store') }}" method="POST" class="space-y-6 relative z-10">
            @csrf
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Adresse Email</label>
                <input type="email" name="email" required 
                       class="w-full px-7 py-4 bg-stone-50 border-none rounded-full focus:ring-2 focus:ring-emerald-600/10 text-sm outline-none transition-all placeholder:text-stone-300"
                       placeholder="votre@email.com">
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Mot de passe</label>
                <input type="password" name="password" required 
                       class="w-full px-7 py-4 bg-stone-50 border-none rounded-full focus:ring-2 focus:ring-emerald-600/10 text-sm outline-none transition-all placeholder:text-stone-300"
                       placeholder="••••••••">
            </div>

            <a href="{{ route('product.index') }}" 
               class="flex items-center justify-center w-full bg-forest text-white py-5 rounded-full font-bold uppercase tracking-[0.2em] text-[11px] shadow-xl shadow-emerald-900/10 hover:bg-emerald-900 hover:-translate-y-0.5 transition-all duration-300 mt-4 no-underline">
                Se Connecter
            </a>
        </form>

        <p class="mt-10 text-center text-[11px] text-stone-400 font-bold uppercase tracking-widest">
            Nouveau chez GluFree ? 
            <a href="{{ route('register.create') }}" class="text-emerald-800 ml-1 hover:underline underline-offset-4 decoration-emerald-200">
                Créer un compte
            </a>
        </p>
    </div>
</div>
@endsection