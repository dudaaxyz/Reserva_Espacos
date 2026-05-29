@extends('layouts.app')

@section('title', 'Minhas Reservas')
@section('subtitle', 'Gerencie suas reservas de espaços')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-bold text-slate-800">Minhas Reservas</h2>
    <a href="{{ route('reservations.create') }}"
       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
        + Nova Reserva
    </a>
</div>

@if($reservations->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 text-center py-16 text-slate-500">
        <p class="font-medium text-slate-700 mb-1">Nenhuma reserva encontrada</p>
        <p class="text-sm mb-6">Você ainda não fez nenhuma reserva.</p>
        <a href="{{ route('reservations.create') }}"
           class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            Fazer primeira reserva
        </a>
    </div>
@else

@php
    $ativas     = $reservations->where('status', 'confirmed');
    $canceladas = $reservations->where('status', 'cancelled');
    $pendentes  = $reservations->whereNotIn('status', ['confirmed', 'cancelled']);
@endphp

{{-- Abas --}}
<div class="flex gap-1 mb-6 bg-slate-100 p-1 rounded-xl w-fit">
    <button onclick="mostrarAba('ativas')"
            id="aba-ativas"
            class="aba-btn px-5 py-2 rounded-lg text-sm font-medium transition-all bg-white text-slate-800 shadow-sm">
        Ativas
        <span class="ml-1.5 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">{{ $ativas->count() }}</span>
    </button>
    <button onclick="mostrarAba('canceladas')"
            id="aba-canceladas"
            class="aba-btn px-5 py-2 rounded-lg text-sm font-medium transition-all text-slate-500">
        Canceladas
        <span class="ml-1.5 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full">{{ $canceladas->count() }}</span>
    </button>
    @if($pendentes->count() > 0)
    <button onclick="mostrarAba('pendentes')"
            id="aba-pendentes"
            class="aba-btn px-5 py-2 rounded-lg text-sm font-medium transition-all text-slate-500">
        Pendentes
        <span class="ml-1.5 px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs rounded-full">{{ $pendentes->count() }}</span>
    </button>
    @endif
</div>

{{-- Tabela Ativas --}}
<div id="tab-ativas">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        @if($ativas->isEmpty())
            <div class="text-center py-12 text-slate-400">
                <p class="text-sm">Nenhuma reserva ativa.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-100">
                            <th class="p-4 font-medium">Espaço</th>
                            <th class="p-4 font-medium">Tipo</th>
                            <th class="p-4 font-medium">Início</th>
                            <th class="p-4 font-medium">Fim</th>
                            <th class="p-4 font-medium">Status</th>
                            <th class="p-4 font-medium text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50">
                        @foreach($ativas as $reservation)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 font-medium text-slate-900">{{ $reservation->space->name }}</td>
                                <td class="p-4 text-slate-600">{{ ucfirst($reservation->space->type) }}</td>
                                <td class="p-4 text-slate-600">{{ $reservation->start_time->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-slate-600">{{ $reservation->end_time->format('d/m/Y H:i') }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Confirmada</span>
                                </td>
                                <td class="p-4 text-right">
                                    <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                                          class="inline" onsubmit="return false" data-form>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="abrirModal(this)"
                                                class="px-3 py-1 border border-red-200 text-red-600 text-xs font-medium rounded-lg hover:bg-red-50 transition-colors">
                                            Cancelar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Tabela Canceladas --}}
<div id="tab-canceladas" class="hidden">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        @if($canceladas->isEmpty())
            <div class="text-center py-12 text-slate-400">
                <p class="text-sm">Nenhuma reserva cancelada.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-100">
                            <th class="p-4 font-medium">Espaço</th>
                            <th class="p-4 font-medium">Tipo</th>
                            <th class="p-4 font-medium">Início</th>
                            <th class="p-4 font-medium">Fim</th>
                            <th class="p-4 font-medium">Status</th>
                            <th class="p-4 font-medium text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50 opacity-70">
                        @foreach($canceladas as $reservation)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 font-medium text-slate-900">{{ $reservation->space->name }}</td>
                                <td class="p-4 text-slate-600">{{ ucfirst($reservation->space->type) }}</td>
                                <td class="p-4 text-slate-600">{{ $reservation->start_time->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-slate-600">{{ $reservation->end_time->format('d/m/Y H:i') }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Cancelada</span>
                                </td>
                                <td class="p-4 text-right">
                                    <span class="text-slate-400 text-xs">—</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@if($pendentes->count() > 0)
<div id="tab-pendentes" class="hidden">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-100">
                        <th class="p-4 font-medium">Espaço</th>
                        <th class="p-4 font-medium">Tipo</th>
                        <th class="p-4 font-medium">Início</th>
                        <th class="p-4 font-medium">Fim</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    @foreach($pendentes as $reservation)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 font-medium text-slate-900">{{ $reservation->space->name }}</td>
                            <td class="p-4 text-slate-600">{{ ucfirst($reservation->space->type) }}</td>
                            <td class="p-4 text-slate-600">{{ $reservation->start_time->format('d/m/Y H:i') }}</td>
                            <td class="p-4 text-slate-600">{{ $reservation->end_time->format('d/m/Y H:i') }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pendente</span>
                            </td>
                            <td class="p-4 text-right">
                                <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                                      class="inline" onsubmit="return false" data-form>
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="abrirModal(this)"
                                            class="px-3 py-1 border border-red-200 text-red-600 text-xs font-medium rounded-lg hover:bg-red-50 transition-colors">
                                        Cancelar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endif

{{-- Modal de confirmação --}}
<div id="modal-cancelar" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="fecharModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl p-8 w-full max-w-md mx-4 z-10">
        <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full mx-auto mb-5">
            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800 text-center mb-2">Cancelar Reserva</h3>
        <p class="text-slate-500 text-sm text-center mb-8">Tem certeza que deseja cancelar esta reserva? Esta ação não pode ser desfeita.</p>
        <div class="flex gap-3">
            <button onclick="fecharModal()"
                    class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                Voltar
            </button>
            <button onclick="confirmarCancelamento()"
                    class="flex-1 px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                Sim, cancelar
            </button>
        </div>
    </div>
</div>

<script>
    let formAtivo = null;

    function mostrarAba(aba) {
        ['ativas', 'canceladas', 'pendentes'].forEach(t => {
            const tab = document.getElementById('tab-' + t);
            const btn = document.getElementById('aba-' + t);
            if (tab) tab.classList.add('hidden');
            if (btn) {
                btn.classList.remove('bg-white', 'text-slate-800', 'shadow-sm');
                btn.classList.add('text-slate-500');
            }
        });

        const tabAtiva = document.getElementById('tab-' + aba);
        const btnAtivo = document.getElementById('aba-' + aba);
        if (tabAtiva) tabAtiva.classList.remove('hidden');
        if (btnAtivo) {
            btnAtivo.classList.add('bg-white', 'text-slate-800', 'shadow-sm');
            btnAtivo.classList.remove('text-slate-500');
        }
    }

    function abrirModal(btn) {
        formAtivo = btn.closest('[data-form]');
        document.getElementById('modal-cancelar').classList.remove('hidden');
        document.getElementById('modal-cancelar').classList.add('flex');
    }

    function fecharModal() {
        document.getElementById('modal-cancelar').classList.add('hidden');
        document.getElementById('modal-cancelar').classList.remove('flex');
        formAtivo = null;
    }

    function confirmarCancelamento() {
        if (formAtivo) {
            formAtivo.onsubmit = null;
            formAtivo.submit();
        }
    }
</script>
@endsection