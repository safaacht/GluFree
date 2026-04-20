@extends('layouts.app')

@section('content')
<div class="min-h-[90vh] flex items-center justify-center py-20 px-6">
    <div class="max-w-2xl w-full bg-white p-16 rounded-[3.5rem] shadow-sm border border-stone-100 relative">
        
        <div class="text-center mb-12">
            <span class="text-emerald-700 font-bold uppercase tracking-[0.2em] text-[10px] mb-3 block">Bienvenue dans l'exception</span>
            <h2 class="font-serif text-4xl text-forest mb-4">Rejoindre <span class="italic text-emerald-800 font-serif">GluFree</span></h2>
            <p class="text-stone-400 text-sm font-light max-w-sm mx-auto leading-relaxed">Choisissez le profil qui correspond à votre art de vivre.</p>
        </div>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-2 gap-6 mb-12">
                <label class="relative group cursor-pointer">
                    <input type="radio" name="role" value="client" class="sr-only peer" checked>
                    <div class="p-8 border border-stone-100 rounded-[2.5rem] text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50/40 transition-all duration-500 group-hover:bg-stone-50">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-stone-400 peer-checked:text-emerald-700">
                            <i class="fa-solid fa-basket-shopping text-xl"></i>
                        </div>
                        <span class="block font-bold text-forest uppercase tracking-[0.2em] text-[10px]">Client Privé</span>
                    </div>
                </label>

                <label class="relative group cursor-pointer">
                    <input type="radio" name="role" value="fournisseur" class="sr-only peer">
                    <div class="p-8 border border-stone-100 rounded-[2.5rem] text-center peer-checked:border-emerald-600 peer-checked:bg-emerald-50/40 transition-all duration-500 group-hover:bg-stone-50">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-stone-400 peer-checked:text-emerald-700">
                            <i class="fa-solid fa-shop text-xl"></i>
                        </div>
                        <span class="block font-bold text-forest uppercase tracking-[0.2em] text-[10px]">Fournisseur</span>
                    </div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Nom complet</label>
                    <input type="text" name="name" required class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Email</label>
                    <input type="email" name="email" required class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Téléphone</label>
                <input type="text" name="tel" required class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all">
            </div>

            <!-- fournisseur fields -->
            <div id="fournisseur-fields" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">CIN</label>
                        <input type="text" name="cin" class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">ICE</label>
                        <input type="text" name="ice" class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Ville</label>
                    <select name="city_id" class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all cursor-pointer">
                        <option value="">Sélectionnez une ville</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Mot de passe</label>
                    <input type="password" name="password" required class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2 ml-4">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" required class="w-full px-7 py-4 bg-stone-50 border-none rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all">
                </div>
            </div>

            <button class="w-full bg-forest text-white py-5 rounded-full font-bold uppercase tracking-[0.2em] text-[11px] shadow-2xl shadow-emerald-900/20 hover:bg-emerald-900 hover:-translate-y-1 transition-all duration-300">
                Créer mon compte
            </button>
        </form>

        <p class="mt-10 text-center text-[11px] text-stone-400 font-bold uppercase tracking-widest">
            Déjà membre ? 
            <a href="{{ route('login') }}" class="text-emerald-800 ml-1 hover:underline underline-offset-4 decoration-emerald-200">Se connecter</a>
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleRadios = document.querySelectorAll('input[name="role"]');
        const fournisseurFields = document.getElementById('fournisseur-fields');

        function toggleFields() {
            const isFournisseur = document.querySelector('input[name="role"]:checked').value === 'fournisseur';
            if (isFournisseur) {
                fournisseurFields.classList.remove('hidden');
            } else {
                fournisseurFields.classList.add('hidden');
            }
        }

        roleRadios.forEach(radio => {
            radio.addEventListener('change', toggleFields);
        });

        toggleFields();
    });
</script>
@endsection