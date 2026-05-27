@extends('layouts.app')

@section('title', 'Nova Reserva')
@section('subtitle', 'Reserve um espaço disponível')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Espaço</label>
                    <select name="space_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Selecione um espaço...</option>
                        @foreach($spaces as $space)
                            <option value="{{ $space->id }}" {{ request('space_id') == $space->id ? 'selected' : '' }}>
                                {{ $space->name }} — {{ ucfirst($space->type) }} · {{ $space->capacity }} pessoas
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Data e Hora de Início</label>
                        <input type="datetime-local" name="start_time" value="{{ old('start_time') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Data e Hora de Fim</label>
                        <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Observações</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Alguma observação sobre a reserva?">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-check"></i> Confirmar Reserva
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