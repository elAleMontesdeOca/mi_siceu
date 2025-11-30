@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500">

        <div class="w-full max-w-md p-8 bg-white/20 backdrop-blur-xl rounded-3xl shadow-2xl
                    border border-white/30 animate-fadeIn">

            <!-- LOGO -->
            <div class="flex justify-center mb-6">
                <img src="/logo_siceu.png" class="w-20 drop-shadow-xl">
            </div>

            <h2 class="text-3xl font-extrabold text-center text-white mb-4">
                Recuperar Contraseña
            </h2>

            <p class="text-center text-white/80 text-sm mb-6">
                Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-white font-semibold">Correo Electrónico</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 shadow-sm outline-none">
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-500 to-green-600 text-white
                           rounded-xl font-bold shadow-lg hover:opacity-90 transition">
                    Enviar Enlace
                </button>
            </form>

            <p class="mt-6 text-center">
                <a href="/login" class="text-yellow-300 hover:text-yellow-400 transition text-sm">
                    Volver al inicio de sesión
                </a>
            </p>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1s ease-out;
        }
    </style>
@endsection