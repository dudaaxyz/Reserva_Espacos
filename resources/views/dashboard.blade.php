@extends('layouts.app')

@section('title', 'Visão Geral')
@section('subtitle', auth()->user()->is_admin ? 'Painel Administrativo' : 'Resumo do sistema de reservas')

@section('content')

@if(auth()->user()->is_admin)
{{-- ==================== PAINEL ADMIN ==================== --}}

{{-- KPI Cards Admin --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div onclick="renderizarTabelaDinamica('espacos', 'Todos os Espaços Registrados')" 
         class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between cursor-pointer hover:border-blue-400 hover:shadow-md transition-all active:scale-[0.98]">
        <div>
            <h3 class="text-slate-500 text-sm font-medium mb-1">Total de Espaços</h3>
            <p class="text-3xl font-bold text-slate-800">{{ $totalSpaces }}</p>
        </div>
        <div class="p-4 rounded-xl bg-blue-50">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
    </div>

    <div onclick="renderizarTabelaDinamica('usuarios', 'Todos os Usuários do Site')" 
         class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between cursor-pointer hover:border-purple-400 hover:shadow-md transition-all active:scale-[0.98]">
        <div>
            <h3 class="text-slate-500 text-sm font-medium mb-1">Total de Usuários</h3>
            <p class="text-3xl font-bold text-slate-800">{{ $totalUsers }}</p>
        </div>
        <div class="p-4 rounded-xl bg-purple-50">
            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
    </div>

    <div onclick="renderizarTabelaDinamica('ativas', 'Reservas Ativas Atualmente')" 
         class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between cursor-pointer hover:border-green-400 hover:shadow-md transition-all active:scale-[0.98]">
        <div>
            <h3 class="text-slate-500 text-sm font-medium mb-1">Reservas Ativas</h3>
            <p class="text-3xl font-bold text-slate-800">{{ $activeReservations }}</p>
        </div>
        <div class="p-4 rounded-xl bg-green-50">
            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <div onclick="renderizarTabelaDinamica('todas-reservas', 'Todas as Reservas do Sistema')" 
         class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between cursor-pointer hover:border-orange-400 hover:shadow-md transition-all active:scale-[0.98]">
        <div>
            <h3 class="text-slate-500 text-sm font-medium mb-1">Total de Reservas</h3>
            <p class="text-3xl font-bold text-slate-800">{{ $totalReservations }}</p>
        </div>
        <div class="p-4 rounded-xl bg-orange-50">
            <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v16a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
    </div>
</div>

{{-- Tabela Inteligente Dinâmica --}}
<div id="container-tabela-dinamica" class="bg-white rounded-xl shadow-sm border border-slate-100 transition-all duration-300">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 id="titulo-tabela-dinamica" class="text-lg font-bold text-slate-800">Dados do Sistema</h3>
            <p id="subtitulo-tabela-dinamica" class="text-xs text-slate-400 mt-0.5">Selecione um indicador acima para analisar.</p>
        </div>
        
        <div class="flex items-center gap-2 max-w-md w-full">
            <div class="relative w-full">
                <input type="text" id="campo-busca-dinamica" oninput="filtrarTextoLocal()" placeholder="Filtrar nesta lista..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                <div class="absolute left-3 top-2.5 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
            <button onclick="limparFiltrosCards()" id="btn-limpar-card" class="hidden text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-2 rounded-lg font-medium transition-colors">
                Fechar
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead id="cabecalho-tabela-dinamica">
                {{-- Cabeçalho dinâmico --}}
            </thead>
            <tbody id="corpo-tabela-dinamica" class="divide-y divide-slate-100">
                <tr id="estado-inicial-msg">
                    <td class="px-6 py-16 text-center text-slate-400 text-sm">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                        <span class="font-medium text-slate-500">Nenhum relatório selecionado</span>
                        <p class="text-xs text-slate-400 mt-1">Clique em um dos cards superiores para carregar as informações na tabela.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    // IMPORTAÇÃO DOS ARRAYS DO CONTROLLER
    const dadosEspacos = @json($spaces ?? []);
    const dadosTodasReservas = @json($allReservations ?? []);
    const dadosReservasAtivas = @json($activeReservationsList ?? []);
    const dadosUsuarios = @json($users ?? []);

    let tipoAtivo = '';

    function limparTexto(texto) {
        return texto ? texto.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim() : '';
    }

    function formatarData(dataString) {
        if(!dataString) return 'N/A';
        const d = new Date(dataString);
        return d.toLocaleString('pt-BR', {day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'});
    }

    function renderizarTabelaDinamica(tipo, titulo) {
        tipoAtivo = tipo;
        const cabecalho = document.getElementById('cabecalho-tabela-dinamica');
        const corpo = document.getElementById('corpo-tabela-dinamica');
        const campoBusca = document.getElementById('campo-busca-dinamica');
        const btnLimpar = document.getElementById('btn-limpar-card');
        
        document.getElementById('titulo-tabela-dinamica').innerText = titulo;
        document.getElementById('subtitulo-tabela-dinamica').innerText = "Listagem filtrável obtida diretamente do banco.";
        
        btnLimpar.classList.remove('hidden');
        campoBusca.value = "";

        let htmlCabecalho = '';
        let htmlCorpo = '';

        if (tipo === 'espacos') {
            htmlCabecalho = `
                <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">Nome do Espaço</th>
                    <th class="px-6 py-3 text-left">Tipo</th>
                    <th class="px-6 py-3 text-left">Capacidade</th>
                </tr>`;
            
            dadosEspacos.forEach(espaco => {
                htmlCorpo += `
                    <tr class="item-dinamico hover:bg-slate-50 transition-colors" data-busca="${limparTexto(espaco.name)} ${limparTexto(espaco.type)}">
                        <td class="px-6 py-4 text-sm font-medium text-slate-800">${espaco.name}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">${espaco.type.charAt(0).toUpperCase() + espaco.type.slice(1)}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">${espaco.capacity} pessoas</td>
                    </tr>`;
            });
        } 
        else if (tipo === 'usuarios') {
            htmlCabecalho = `
                <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">Nome do Usuário</th>
                    <th class="px-6 py-3 text-left">E-mail de Cadastro</th>
                </tr>`;

            dadosUsuarios.forEach(user => {
                htmlCorpo += `
                    <tr class="item-dinamico hover:bg-slate-50 transition-colors" data-busca="${limparTexto(user.name)} ${limparTexto(user.email)}">
                        <td class="px-6 py-4 text-sm font-medium text-slate-800">${user.name}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">${user.email}</td>
                    </tr>`;
            });
        } 
        else if (tipo === 'todas-reservas' || tipo === 'ativas') {
            htmlCabecalho = `
                <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">Usuário</th>
                    <th class="px-6 py-3 text-left">Espaço</th>
                    <th class="px-6 py-3 text-left">Início</th>
                    <th class="px-6 py-3 text-left">Fim</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>`;

            const dataset = (tipo === 'ativas') ? dadosReservasAtivas : dadosTodasReservas;

            if(dataset.length === 0) {
                htmlCorpo = `<tr><td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm font-medium">Nenhum registo ativo encontrado.</td></tr>`;
            } else {
                dataset.forEach(r => {
                    let badge = r.status === 'confirmed' 
                        ? '<span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Confirmada</span>'
                        : '<span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Cancelada</span>';

                    htmlCorpo += `
                        <tr class="item-dinamico hover:bg-slate-50 transition-colors" data-busca="${limparTexto(r.user?.name)} ${limparTexto(r.space?.name)}">
                            <td class="px-6 py-4 text-sm font-medium text-slate-800">${r.user?.name || 'N/A'}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">${r.space?.name || 'N/A'}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">${formatarData(r.start_time)}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">${formatarData(r.end_time)}</td>
                            <td class="px-6 py-4">${badge}</td>
                        </tr>`;
                });
            }
        }

        cabecalho.innerHTML = htmlCabecalho;
        corpo.innerHTML = htmlCorpo;
        setTimeout(() => campoBusca.focus(), 50);
    }

    function filtrarTextoLocal() {
        const campoBusca = document.getElementById('campo-busca-dinamica');
        const busca = limparTexto(campoBusca.value);
        if (tipoAtivo === '') { campoBusca.value = ""; return; }

        const linhas = document.querySelectorAll('.item-dinamico');
        const corpo = document.getElementById('corpo-tabela-dinamica');
        const cabecalho = document.getElementById('cabecalho-tabela-dinamica');
        
        const msgErroAnterior = document.getElementById('busca-vazia-feedback');
        if(msgErroAnterior) msgErroAnterior.remove();

        let linhasVisiveis = 0;
        linhas.forEach(linha => {
            const conteudoBusca = linha.getAttribute('data-busca') || '';
            if(conteudoBusca.includes(busca)) {
                linha.style.setProperty("display", "", "important");
                linhasVisiveis++;
            } else {
                linha.style.setProperty("display", "none", "important");
            }
        });

        if (linhasVisiveis === 0 && busca !== "") {
            const cols = cabecalho.querySelectorAll('th').length || 3;
            const trVazio = document.createElement('tr');
            trVazio.id = "busca-vazia-feedback";
            trVazio.innerHTML = `<td colspan="${cols}" class="px-6 py-12 text-center text-slate-400 text-sm">Nenhum resultado corresponde à busca.</td>`;
            corpo.appendChild(trVazio);
        }
    }

    function limparFiltrosCards() {
        tipoAtivo = '';
        document.getElementById('btn-limpar-card').classList.add('hidden');
        document.getElementById('campo-busca-dinamica').value = "";
        document.getElementById('titulo-tabela-dinamica').innerText = "Dados do Sistema";
        document.getElementById('subtitulo-tabela-dinamica').innerText = "Selecione um indicador acima para analisar.";
        document.getElementById('cabecalho-tabela-dinamica').innerHTML = "";
        document.getElementById('corpo-tabela-dinamica').innerHTML = `
            <tr id="estado-inicial-msg">
                <td class="px-6 py-16 text-center text-slate-400 text-sm">
                    <span class="font-medium text-slate-500">Nenhum relatório selecionado</span>
                </td>
            </tr>`;
    }
</script>

@else
{{-- ==================== PAINEL USUÁRIO NORMAL ==================== --}}

{{-- KPI Cards Usuário --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-slate-500 text-sm font-medium mb-1">Espaços Disponíveis</h3>
            <p class="text-3xl font-bold text-slate-800">{{ $totalSpaces }}</p>
        </div>
        <div class="p-4 rounded-xl bg-blue-50">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-slate-500 text-sm font-medium mb-1">Minhas Reservas</h3>
            <p class="text-3xl font-bold text-slate-800">{{ $myReservations }}</p>
        </div>
        <div class="p-4 rounded-xl bg-orange-50">
            <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-slate-500 text-sm font-medium mb-1">Reservas Ativas</h3>
            <p class="text-3xl font-bold text-slate-800">{{ $activeReservations }}</p>
        </div>
        <div class="p-4 rounded-xl bg-green-50">
            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
</div>

{{-- Ações rápidas --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <a href="{{ route('reservations.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white p-5 rounded-xl flex items-center gap-4 transition-all active:scale-[0.98]">
        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <div>
            <p class="font-bold text-white">Nova Reserva</p>
            <p class="text-blue-100 text-sm">Reservar um espaço disponível</p>
        </div>
    </a>

    <a href="{{ route('reservations.index') }}" 
       class="bg-white hover:bg-slate-50 text-slate-800 p-5 rounded-xl flex items-center gap-4 border border-slate-100 transition-all active:scale-[0.98]">
        <div class="p-2 bg-slate-100 rounded-lg">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <div>
            <p class="font-bold text-slate-800">Minhas Reservas</p>
            <p class="text-slate-500 text-sm">Ver e gerenciar suas reservas</p>
        </div>
    </a>
</div>

{{-- Tabela de reservas recentes do usuário --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Minhas Reservas Recentes</h3>
            <p class="text-xs text-slate-400 mt-0.5">Últimas reservas realizadas por você</p>
        </div>
        <a href="{{ route('reservations.index') }}" class="text-sm text-blue-600 hover:underline font-medium">Ver todas</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">Espaço</th>
                    <th class="px-6 py-3 text-left">Início</th>
                    <th class="px-6 py-3 text-left">Fim</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($myRecentReservations ?? [] as $reserva)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $reserva->space->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ \Carbon\Carbon::parse($reserva->start_time)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ \Carbon\Carbon::parse($reserva->end_time)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($reserva->status === 'confirmed')
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Confirmada</span>
                        @elseif($reserva->status === 'canceled')
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Cancelada</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pendente</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-sm">
                        <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium text-slate-500">Nenhuma reserva encontrada</span>
                        <p class="text-xs mt-1">Clique em "Nova Reserva" para começar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif
@endsection