@extends('layouts.app')

@section('title', 'Editar Espaço')
@section('subtitle', 'Atualize as informações do espaço')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
        <form method="POST" action="{{ route('spaces.update', $space) }}">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nome do Espaço</label>
                    <input type="text" name="name" value="{{ old('name', $space->name) }}"
                           class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tipo</label>
                    <select name="type" class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500">
                        <option value="sala" {{ $space->type == 'sala' ? 'selected' : '' }}><i class="fas fa-building"></i> Sala de Reunião</option>
                        <option value="estacao" {{ $space->type == 'estacao' ? 'selected' : '' }}><i class="fas fa-desktop"></i> Estação de Trabalho</option>
                        <option value="coworking" {{ $space->type == 'coworking' ? 'selected' : '' }}><i class="fas fa-handshake"></i> Coworking</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Capacidade (pessoas)</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $space->capacity) }}"
                           class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Descrição</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $space->description) }}</textarea>
                </div>

                <div class="flex gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Atualizar
                    </button>
                    <a href="{{ route('spaces.index') }}"
                       class="px-6 py-2 border border-slate-200 text-slate-600 font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection