@extends('layouts.app')

@section('title', 'Espaços Disponíveis')
@section('subtitle', 'Gerencie os espaços de coworking e salas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-bold text-slate-800">Espaços Cadastrados</h2>
    <a href="{{ route('spaces.create') }}"
       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
        + Novo Espaço
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($spaces as $space)
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                    @if($space->type == 'sala')<i class="fas fa-building"></i>
                    @elseif($space->type == 'estacao')<i class="fas fa-desktop"></i>
                    @else<i class="fas fa-handshake"></i>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $space->name }}</h3>
                    <p class="text-slate-500 text-sm">{{ ucfirst($space->type) }}</p>
                </div>
            </div>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Capacidade</span>
                    <span class="font-medium text-slate-800">{{ $space->capacity }} pessoas</span>
                </div>
                @if($space->description)
                <p class="text-slate-500 text-sm">{{ $space->description }}</p>
                @endif
            </div>
            <div class="flex gap-2 pt-4 border-t border-slate-100">
                <a href="{{ route('reservations.create', ['space_id' => $space->id]) }}"
                   class="flex-1 text-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                    Reservar
                </a>
                <a href="{{ route('spaces.edit', $space) }}"
                   class="flex-1 text-center px-3 py-2 border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                    Editar
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-12 text-slate-500">
            Nenhum espaço cadastrado ainda.
            <a href="{{ route('spaces.create') }}" class="text-blue-600 hover:underline ml-1">Criar primeiro espaço</a>
        </div>
    @endforelse
</div>
@endsection