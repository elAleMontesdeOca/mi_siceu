@extends('layouts.estudiante')

@section('content')

    <h1 class="text-3xl font-bold text-blue-800 mb-6">Mis Eventos</h1>

    {{-- TOASTS YA VAN EN EL LAYOUT --}}

    {{-- ================================
    PRÓXIMOS EVENTOS
    ================================ --}}
    <h2 class="text-2xl font-semibold text-gray-800 mb-3">Próximos eventos</h2>

    @if($proximos->count() == 0)
        <p class="text-gray-500 mb-6">No tienes eventos próximos.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">

            @foreach($proximos as $registro)
                @php
                    $evento = $registro->evento;
                    $inscritos = $evento->registros()->where('estado', 'INSCRITO')->count();
                    $cupoLleno = $inscritos >= $evento->cupo_max;
                @endphp

                @if($evento)
                    <div
                        class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:shadow-2xl hover:-translate-y-1 duration-300">

                        <!-- Banner -->
                        <div class="h-40 bg-gradient-to-r from-emerald-500 to-blue-600 flex items-center justify-center text-white">
                            <svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5">
                                <use href="#academic-cap" />
                            </svg>
                        </div>

                        <div class="p-6 space-y-3">

                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-bold text-gray-900">
                                    {{ $evento->titulo }}
                                </h2>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    Próximo
                                </span>
                            </div>

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

                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5">
                                    <use href="#calendar-days" />
                                </svg>
                                <span>{{ date('d/m/Y', strtotime($evento->fecha)) }}</span>
                            </div>

                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5">
                                    <use href="#clock" />
                                </svg>
                                <span>{{ $evento->hora_inicio }} – {{ $evento->hora_fin }}</span>
                            </div>

                            <div class="flex items-center gap-2 text-gray-500 text-sm">
                                <span class="font-semibold">Registrado el:</span>
                                <span>{{ $registro->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            <div class="flex gap-3 mt-3">
                                <a href="{{ route('estudiante.eventos.show', $evento->id) }}"
                                    class="flex-1 text-center py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Ver detalles
                                </a>
                                <a href="{{ route('registro.qr', $registro->id) }}"
                                    class="block text-center py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm">
                                    Ver mi código QR
                                </a>


                                <form method="POST" action="{{ route('estudiante.mis-eventos.cancelar', $registro->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                        Cancelar
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif


    {{-- ================================
    EVENTOS FINALIZADOS
    ================================ --}}
    <h2 class="text-2xl font-semibold text-gray-800 mb-3">Eventos finalizados</h2>

    @if($finalizados->count() == 0)
        <p class="text-gray-500 mb-6">No tienes eventos finalizados.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @foreach($finalizados as $registro)
                @php $evento = $registro->evento; @endphp
                @if($evento)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

                        <div class="h-32 bg-gray-300 flex items-center justify-center text-white">
                            <span class="text-lg font-semibold">Finalizado</span>
                        </div>

                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-bold text-gray-900">
                                    {{ $evento->titulo }}
                                </h2>
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-700">
                                    Finalizado
                                </span>
                            </div>

                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5">
                                    <use href="#calendar-days" />
                                </svg>
                                <span>{{ date('d/m/Y', strtotime($evento->fecha)) }}</span>
                            </div>

                            <a href="{{ route('estudiante.eventos.show', $evento->id) }}"
                                class="block text-center mt-2 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif


    {{-- ================================
    CANCELADOS
    ================================ --}}
    <h2 class="text-2xl font-semibold text-gray-800 mb-3">Inscripciones canceladas</h2>

    @if($cancelados->count() == 0)
        <p class="text-gray-500">No tienes inscripciones canceladas.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($cancelados as $registro)
                @php
                    $evento = $registro->evento;
                    $inscritos = $evento->registros()->where('estado', 'INSCRITO')->count();
                    $cupoLleno = $inscritos >= $evento->cupo_max;
                @endphp

                @if($evento)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden opacity-80">

                        <div class="h-32 bg-red-100 flex items-center justify-center text-red-600">
                            <span class="text-lg font-semibold">Cancelado</span>
                        </div>

                        <div class="p-6 space-y-3">

                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-bold text-gray-900">
                                    {{ $evento->titulo }}
                                </h2>
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">
                                    Cancelado
                                </span>
                            </div>

                            <!-- Cupo lleno -->
                            @if($cupoLleno)
                                <span class="inline-block px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">
                                    Cupo lleno
                                </span>
                            @endif

                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5">
                                    <use href="#calendar-days" />
                                </svg>
                                <span>{{ date('d/m/Y', strtotime($evento->fecha)) }}</span>
                            </div>

                            <!-- Botón dinámico -->
                            @if(!$cupoLleno)
                                <a href="{{ route('estudiante.eventos.show', $evento->id) }}"
                                    class="block text-center mt-2 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm">
                                    Ver detalles / Volver a inscribirme
                                </a>
                            @else
                                <button disabled
                                    class="block w-full mt-2 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed text-sm">
                                    Cupo lleno
                                </button>
                            @endif

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

@endsection