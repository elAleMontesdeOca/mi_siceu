@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500">

        <!-- TARJETA -->
        <div class="relative w-full max-w-md p-8 bg-white/20 backdrop-blur-xl rounded-3xl shadow-2xl
                    border border-white/30 animate-fadeIn">

            <!-- LOGO -->
            <div class="flex justify-center mb-6">
                <img src="/logo_siceu.png" class="w-24 drop-shadow-lg">
            </div>

            <h2 class="text-3xl font-extrabold text-center text-white tracking-wide mb-8">
                Iniciar Sesión
            </h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-400/20 p-3 text-white rounded-lg border border-red-300">
                    <ul class="text-sm list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label class="text-white font-semibold">Correo Electrónico</label>
                    <input type="email" name="email" required autofocus class="w-full px-4 py-2 mt-1 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 outline-none shadow-sm">
                </div>

                <!-- Password -->
                <div>
                    <label class="text-white font-semibold">Contraseña</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 mt-1 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 outline-none shadow-sm">
                </div>

                <!-- Forgot Password -->
                <div class="flex justify-end">
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-200 hover:text-white transition">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <!-- Botón -->
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-500 to-green-600 text-white 
                           font-bold rounded-xl shadow-lg hover:opacity-90 transition">
                    Iniciar Sesión
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-white/80">
                ¿No tienes cuenta?
                <a href="/register" class="text-yellow-300 font-semibold hover:text-yellow-400 transition">
                    Regístrate aquí
                </a>
            </p>

        </div>
    </div>

    <!-- Animación -->
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
            animation: fadeIn 0.8s ease-out;
        }
    </style>
@endsection