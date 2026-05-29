@extends('layouts.app')

@section('title', 'Meu Perfil')
@section('subtitle', 'Gerencie suas informações pessoais')

@section('content')

{{-- Avisos de sucesso/erro --}}
@if (session('status') === 'profile-updated')
    <div id="toast-profile" class="mb-4 p-4 bg-green-100 text-green-800 rounded-xl border border-green-200 flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Perfil atualizado com sucesso!
    </div>
@endif

@if (session('status') === 'password-updated')
    <div id="toast-password" class="mb-4 p-4 bg-green-100 text-green-800 rounded-xl border border-green-200 flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Senha alterada com sucesso!
    </div>
@endif

@if ($errors->updatePassword->any())
    <div id="toast-err-password" class="mb-4 p-4 bg-red-100 text-red-800 rounded-xl border border-red-200 flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Erro ao alterar senha. Verifique os campos e tente novamente.
    </div>
@endif

@if ($errors->any() && !$errors->updatePassword->any() && !$errors->userDeletion->any())
    <div id="toast-err-profile" class="mb-4 p-4 bg-red-100 text-red-800 rounded-xl border border-red-200 flex items-center gap-2 text-sm">
        <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Erro ao salvar perfil. Verifique os campos e tente novamente.
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Coluna esquerda --}}
    <div class="space-y-6">

        {{-- Informações pessoais --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Informações Pessoais</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nome</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Salvar Alterações
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Excluir conta --}}
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-8">
            <h3 class="text-lg font-bold text-red-600 mb-2">Excluir Conta</h3>
            <p class="text-slate-500 text-sm mb-4">Após excluir sua conta, todos os dados serão permanentemente removidos.</p>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Digite sua senha para confirmar</label>
                    <input type="password" name="password"
                           class="block w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-red-500 focus:border-red-500"
                           placeholder="••••••••">
                    @error('password', 'userDeletion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                        onclick="return confirm('Tem certeza? Esta ação não pode ser desfeita!')"
                        class="px-6 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                    Excluir Minha Conta
                </button>
            </form>
        </div>
    </div>

    {{-- Coluna direita — Alterar senha --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8 h-fit">
        <h3 class="text-lg font-bold text-slate-800 mb-6">Alterar Senha</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Senha Atual</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input type="password" name="current_password" id="current_password"
                               class="block w-full pl-10 pr-10 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePass('current_password','eye_c','eyeoff_c')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg id="eye_c" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eyeoff_c" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                    @error('current_password', 'updatePassword') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nova Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input type="password" name="password" id="new_password"
                               class="block w-full pl-10 pr-10 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Mínimo 8 caracteres">
                        <button type="button" onclick="togglePass('new_password','eye_n','eyeoff_n')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg id="eye_n" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eyeoff_n" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                    @error('password', 'updatePassword') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Confirmar Nova Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input type="password" name="password_confirmation" id="confirm_password"
                               class="block w-full pl-10 pr-10 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Repita a nova senha">
                        <button type="button" onclick="togglePass('confirm_password','eye_cf','eyeoff_cf')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg id="eye_cf" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eyeoff_cf" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Atualizar Senha
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function togglePass(inputId, eyeId, eyeOffId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
    const eyeOff = document.getElementById(eyeOffId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.add('hidden');
        eyeOff.classList.remove('hidden');
    } else {
        input.type = 'password';
        eye.classList.remove('hidden');
        eyeOff.classList.add('hidden');
    }
}

// Auto-hide dos avisos após 4 segundos
['toast-profile', 'toast-password', 'toast-err-password', 'toast-err-profile'].forEach(id => {
    const el = document.getElementById(id);
    if (el) setTimeout(() => el.style.display = 'none', 4000);
});
</script>
@endsection