<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GluFree | Gestion Sans Gluten</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FCFBFA; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .text-forest { color: #1B3C35; }
        .bg-forest { background-color: #1B3C35; }
        .btn-elegant { 
            background-color: #1B3C35;
            transition: all 0.3s ease;
        }
        .btn-elegant:hover {
            background-color: #2D5A50;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="text-slate-800">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-stone-100 px-10 py-5 flex justify-between items-center">
        <a href="/" class="flex items-center gap-2 group">
            <div class="bg-forest text-white w-9 h-9 flex items-center justify-center rounded-lg font-serif italic text-xl shadow-lg">G</div>
            <span class="font-serif text-2xl font-bold tracking-tight text-forest">
                Glu<span class="text-emerald-700 italic">Free</span>
            </span>
        </a>

        <div class="hidden md:flex items-center gap-10 text-[13px] font-semibold uppercase tracking-widest text-stone-500">
            <a href="/" class="hover:text-forest transition">Accueil</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-forest transition">Gestion Admin</a>
                @elseif(auth()->user()->role === 'fournisseur')
                    <a href="{{ route('fournisseur.dashboard') }}" class="text-emerald-800">Espace Fournisseur</a>
                @endif
            @endauth
        </div>

        <div class="flex items-center gap-6">
            @auth
                <div class="flex items-center gap-5 border-l pl-6 border-stone-200">
                    <a href="{{ route('profile.edit') }}" class="text-stone-600 hover:text-forest transition">
                        <i class="fa-regular fa-user text-lg"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="text-[11px] font-bold uppercase tracking-widest text-red-700/60 hover:text-red-600 transition">Quitter</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login.create') }}" class="text-sm font-semibold text-stone-600 hover:text-forest transition">Connexion</a>
                <a href="{{ route('register.create') }}" class="btn-elegant text-white px-7 py-2.5 rounded-full text-[12px] font-bold uppercase tracking-widest shadow-xl shadow-emerald-900/10">
                    Rejoindre
                </a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>