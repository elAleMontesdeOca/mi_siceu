@extends('layouts.estudiante')

@section('content')

    <h1 class="text-3xl font-bold text-blue-800 mb-8">Eventos Activos</h1>

    @if($eventos->count() == 0)
        <div class="bg-white shadow p-8 rounded-xl text-center">
            <h2 class="text-xl font-semibold text-gray-700">No hay eventos disponibles por ahora.</h2>
            <p class="text-gray-500 mt-2">Vuelve más tarde.</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($eventos as $evento)

            @php
                $inscritos = $evento->registros()->where('estado', 'INSCRITO')->count();
                $cupoLleno = $inscritos >= $evento->cupo_max;
            @endphp

            <div
                class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:shadow-2xl hover:-translate-y-1 duration-300">

                <!-- Banner -->
                <div class="h-40 bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center text-white">
                    <svg class="w-16 h-16 opacity-70" fill="none" stroke="currentColor" stroke-width="1.5">
                        <use href="#academic-cap" />
                    </svg>
                </div>

                <div class="p-6 space-y-4">

                    <!-- Título -->
                    <h2 class="text-xl font-bold text-gray-800">{{ $evento->titulo }}</h2>

                    <!-- Categoría -->
                    <span class="inline-block px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-full">
                        {{ $evento->categoria->nombre }}
                    </span>

                    <!-- Cupo lleno -->
                    @if($cupoLleno)
                        <span class="inline-block px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">
                            Cupo lleno
                        </span>
                    @endif

                    <!-- Fecha -->
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5">
                            <use href="#calendar-days" />
                        </svg>
                        <span>{{ date('d/m/Y', strtotime($evento->fecha)) }}</span>
                    </div>

                    <!-- Horario -->
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5">
                            <use href="#clock" />
                        </svg>
                        <span>{{ $evento->hora_inicio }} – {{ $evento->hora_fin }}</span>
                    </div>

                    <!-- Lugar -->
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5">
                            <use href="#map-pin" />
                        </svg>
                        <span>{{ $evento->lugar }}</span>
                    </div>

                    <!-- Botón Ver más -->
                    <a href="{{ route('estudiante.eventos.show', $evento->id) }}"
                        class="block text-center w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Ver más
                    </a>

                </div>
            </div>

        @endforeach
    </div>

@endsection