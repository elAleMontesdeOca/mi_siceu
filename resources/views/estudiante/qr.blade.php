@extends('layouts.estudiante')

@section('content')

<div class="bg-white shadow-xl rounded-2xl p-8 text-center max-w-lg mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 mb-4">Mi código QR</h1>

    <p class="text-gray-600 mb-4">
        Presenta este código al personal autorizado para registrar tu asistencia al evento.
    </p>

    <div class="mb-6 flex justify-center">
        <img
            src="data:image/svg+xml;base64,{{ $qrBase64 }}"
            alt="Código QR de asistencia"
            class="w-64 h-64"
        >
    </div>

    <h2 class="font-bold text-gray-900 mb-1">
        {{ $registro->evento->titulo }}
    </h2>

    <p class="text-sm text-gray-600 mb-4">
        {{ date('d/m/Y', strtotime($registro->evento->fecha)) }} —
        {{ $registro->evento->hora_inicio }}–{{ $registro->evento->hora_fin }}
    </p>

    <a href="{{ route('estudiante.mis-eventos') }}"
       class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
        Volver a Mis eventos
    </a>

</div>

@endsection
