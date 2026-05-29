<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login — Reserva de Espaços</title>
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
                    Gerencie reservas de salas e espaços de coworking com facilidade e segurança.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-slate-800">Bem-vindo de volta</h2>
                    <p class="text-slate-500 mt-2">Acesse sua conta para continuar</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
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

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required
                                   class="block w-full pl-10 pr-10 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-900 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="••••••••">
                            <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-end mt-1">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                    Esqueceu a senha?
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300">
                        <label for="remember" class="text-sm text-slate-600">Lembrar de mim</label>
                    </div>

                    <button type="submit"
                            class="w-full py-3 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Entrar no Sistema
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-slate-500">
                    Ainda não tem uma conta?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Criar conta
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>