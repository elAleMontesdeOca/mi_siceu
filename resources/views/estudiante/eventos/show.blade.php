@extends('layouts.estudiante')

@section('content')

    @php
        $inscritos = $evento->registros()->where('estado', 'INSCRITO')->count();
        $cupoLleno = $inscritos >= $evento->cupo_max;
    @endphp

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <!-- Banner -->
        <div class="h-56 bg-gradient-to-r from-indigo-600 to-blue-600 flex items-center justify-center text-white">
            <svg class="w-24 h-24 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5">
                <use href="#academic-cap" />
            </svg>
        </div>

        <div class="p-8 space-y-6">

            <h1 class="text-3xl font-bold text-gray-900">{{ $evento->titulo }}</h1>

            <span class="px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                {{ $evento->categoria->nombre }}
            </span>

            @if($cupoLleno)
                <span class="px-4 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                    Cupo lleno
                </span>
            @endif

            <p class="text-gray-600 leading-7 text-lg">
                {{ $evento->descripcion ?? 'Sin descripción disponible.' }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                <div class="p-4 bg-gray-50 rounded-xl shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-1">Fecha</h3>
                    <p class="font-semibold text-gray-800">
                        {{ date('d/m/Y', strtotime($evento->fecha)) }}
                    </p>
                </div>

                <div class="p-4 bg-gray-50 rounded-xl shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-1">Horario</h3>
                    <p class="font-semibold text-gray-800">
                        {{ $evento->hora_inicio }} – {{ $evento->hora_fin }}
                    </p>
                </div>

                <div class="p-4 bg-gray-50 rounded-xl shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-1">Lugar</h3>
                    <p class="font-semibold text-gray-800">{{ $evento->lugar }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-xl shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-1">Cupo máximo</h3>
                    <p class="font-semibold text-gray-800">{{ $evento->cupo_max }}</p>
                </div>
            </div>

            @if(!$cupoLleno)
                <form method="POST" action="{{ route('estudiante.registrarse', $evento->id) }}">
                    @csrf
                    <button
                        class="w-full md:w-auto px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                        Registrarme al evento
                    </button>
                </form>
            @else
                <button disabled class="w-full md:w-auto px-6 py-3 bg-gray-400 text-white rounded-xl cursor-not-allowed">
                    Cupo lleno
                </button>
            @endif

        </div>
    </div>

@endsection