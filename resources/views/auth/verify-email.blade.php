@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

    <div class="bg-white shadow-lg rounded-2xl p-10 w-full max-w-lg">

        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">
            Verifica tu Correo Electrónico
        </h2>

        <p class="text-gray-700 text-center mb-6">
            Para continuar, por favor revisa el enlace que enviamos a tu correo electrónico.
            Si no lo recibiste, puedes solicitar otro.
        </p>

        <!-- MENSAJE DE ÉXITO -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">
                Se ha enviado un nuevo enlace de verificación a tu correo.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button type="submit"
                class="w-full py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                Reenviar Enlace de Verificación
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full py-2 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition">
                Cerrar Sesión
            </button>
        </form>

    </div>
</div>
@endsection
