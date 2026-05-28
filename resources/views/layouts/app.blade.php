<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reserva de Espaços</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans">
    <div class="flex h-screen">
        <aside class="w-64 bg-slate-900 text-white flex flex-col">
            <div class="p-6 text-xl font-bold border-b border-slate-800">
                <i class="fas fa-building"></i> Reserva de Espaços
            </div>
            <nav class="p-4 flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'block p-3 bg-blue-600 rounded-lg font-medium text-white' : 'block p-3 hover:bg-slate-800 rounded-lg text-slate-300' }} transition-colors">
                            <i class="fas fa-chart-line"></i> Visão Geral
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('spaces.index') }}"
                           class="{{ request()->routeIs('spaces.*') ? 'block p-3 bg-blue-600 rounded-lg font-medium text-white' : 'block p-3 hover:bg-slate-800 rounded-lg text-slate-300' }} transition-colors">
                            <i class="fas fa-building"></i> Espaços
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reservations.index') }}"
                        class="{{ request()->routeIs('reservations.*') ? 'block p-3 bg-blue-600 rounded-lg font-medium text-white' : 'block p-3 hover:bg-slate-800 rounded-lg text-slate-300' }} transition-colors">
                            <i class="fas fa-calendar-alt"></i> Minhas Reservas
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 p-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt"></i> Sair do Sistema
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white p-6 shadow-sm flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">@yield('title', 'Dashboard')</h1>
                    <p class="text-sm text-slate-500">@yield('subtitle', 'Bem-vindo ao sistema')</p>
                </div>
                <div class="flex items-center gap-3 relative" x-data="{ open: false }">
    <span class="text-sm text-slate-600">{{ Auth::user()->name }}</span>
    <button @click="open = !open"
            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold hover:bg-blue-200 transition-colors">
        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
    </button>

    <div x-show="open" @click.away="open = false"
         x-transition
         class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Meu Perfil
        </a>
        <div class="border-t border-slate-100 my-1"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sair do Sistema
            </button>
        </form>
    </div>
</div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl border border-green-200">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-xl border border-red-200">
                        @foreach($errors->all() as $error)
                            <p> <i class="fas fa-times-circle text-red-600"></i>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>