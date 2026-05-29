<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Senha — Reserva de Espaços</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans">
    <div class="flex h-screen w-full">

        <div class="hidden lg:flex w-1/2 bg-slate-900 items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-600 opacity-20 transform -skew-x-12 translate-x-1/4"></div>
            <div class="relative z-10 text-white max-w-lg">
                <svg class="w-16 h-16 text-blue-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h1 class="text-5xl font-bold mb-6">Reserva de Espaços</h1>
                <p class="text-xl text-slate-300">
                    Recupere o acesso à sua conta para continuar gerenciando suas reservas.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-sm border border-slate-100">

                <div class="mb-8 text-center">
                    <div class="mx-auto w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800">Esqueceu a senha?</h2>
                    <p class="text-slate-500 mt-2 text-sm">Digite seu e-mail e enviaremos um link para redefinir sua senha.</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl border border-green-200 flex items-center gap-2 text-sm">
                        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        E-mail de recuperação enviado! Verifique sua caixa de entrada.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-xl border border-red-200 flex items-center gap-2 text-sm">
                        <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">E-mail cadastrado</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="seu@email.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full py-3 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Enviar link de recuperação
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar para o login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>