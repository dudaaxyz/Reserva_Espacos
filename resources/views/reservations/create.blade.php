@extends('layouts.app')

@section('title', 'Nova Reserva')
@section('subtitle', 'Reserve um espaço disponível')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">

        {{-- Erros de validação --}}
        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <ul class="space-y-1">
                @foreach($errors->all() as $erro)
                    <li class="flex items-center gap-2 text-sm text-red-600">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ $erro }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

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
                        <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Data e Hora de Fim</label>
                        <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}"
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

{{-- Validação no front: fim sempre depois do início --}}
<script>
    const inicio = document.getElementById('start_time');
    const fim    = document.getElementById('end_time');

    // Define mínimo de início como agora
    const agora = new Date();
    agora.setSeconds(0, 0);
    inicio.min = agora.toISOString().slice(0, 16);

    inicio.addEventListener('change', () => {
        if (inicio.value) {
            fim.min = inicio.value;
            if (fim.value && fim.value <= inicio.value) {
                fim.value = '';
            }
        }
    });
</script>
@endsection