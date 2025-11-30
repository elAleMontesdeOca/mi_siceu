@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500">

        <!-- CARD -->
        <div class="relative w-full max-w-md p-8 bg-white/20 backdrop-blur-xl rounded-3xl shadow-2xl 
                    border border-white/30 animate-fadeIn">

            <!-- LOGO -->
            <div class="flex justify-center mb-6">
                <img src="/logo_siceu.png" class="w-24 drop-shadow-lg">
            </div>

            <h2 class="text-3xl font-extrabold text-center text-white tracking-wide mb-8">
                Crear Cuenta
            </h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Nombre -->
                <div>
                    <label class="text-white font-semibold">Nombre Completo</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 mt-1 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 outline-none shadow-sm">
                </div>

                <!-- Matrícula -->
                <div>
                    <label class="text-white font-semibold">Matrícula</label>
                    <input type="text" name="matricula" required class="w-full px-4 py-2 mt-1 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 outline-none shadow-sm">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-white font-semibold">Correo Electrónico</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 mt-1 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 outline-none shadow-sm">
                </div>

                <!-- Password -->
                <div>
                    <label class="text-white font-semibold">Contraseña</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 mt-1 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 outline-none shadow-sm">
                </div>

                <!-- Confirm -->
                <div>
                    <label class="text-white font-semibold">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 mt-1 bg-white/90 border rounded-lg focus:ring-2 
                               focus:ring-blue-400 outline-none shadow-sm">
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-500 to-green-600 text-white 
                           font-bold rounded-xl shadow-lg hover:opacity-90 transition">
                    Crear Cuenta
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-white/80">
                ¿Ya tienes cuenta?
                <a href="/login" class="text-yellow-300 font-semibold hover:text-yellow-400 transition">
                    Inicia sesión
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
            animation: fadeIn 0.8s ease-out;
        }
    </style>
@endsection