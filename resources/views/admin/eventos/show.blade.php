@extends('layouts.app')

@section('content')

    <div class="p-8">

        <!-- TÍTULO + BOTONES -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-700">
                Reporte del Evento: {{ $evento->titulo }}
            </h1>

            <div class="flex gap-3">
                <a href="{{ route('eventos.export.csv', $evento->id) }}"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg shadow hover:bg-emerald-700 transition">
                    Exportar CSV
                </a>

                <a href="{{ route('eventos.export.pdf', $evento->id) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                    Exportar PDF
                </a>
            </div>
        </div>

        <!-- DATOS DEL EVENTO -->
        <div class="bg-white p-6 rounded-xl shadow mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Información del evento</h2>

                <p><strong>Categoría:</strong> {{ $evento->categoria->nombre }}</p>
                <p><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($evento->fecha)) }}</p>
                <p><strong>Horario:</strong> {{ $evento->hora_inicio }} – {{ $evento->hora_fin }}</p>
                <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
                <p><strong>Cupo máximo:</strong> {{ $evento->cupo_max }}</p>
            </div>

            <!-- INDICADORES -->
            <div class="grid grid-cols-2 gap-4">

                <div class="p-4 bg-blue-50 rounded-lg shadow text-center">
                    <h3 class="text-blue-700 font-semibold">Inscritos</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $totalInscritos }}</p>
                </div>

                <div class="p-4 bg-green-50 rounded-lg shadow text-center">
                    <h3 class="text-green-700 font-semibold">Asistencias</h3>
                    <p class="text-3xl font-bold text-green-900">{{ $totalAsistencias }}</p>
                </div>

                <div class="p-4 bg-amber-50 rounded-lg shadow text-center">
                    <h3 class="text-amber-700 font-semibold">Cancelados</h3>
                    <p class="text-3xl font-bold text-amber-900">{{ $totalCancelados }}</p>
                </div>

                <div class="p-4 bg-indigo-50 rounded-lg shadow text-center">
                    <h3 class="text-indigo-700 font-semibold">Cupo Ocupado</h3>
                    <p class="text-2xl font-bold text-indigo-900">
                        {{ $porcentajeOcupado }}%
                    </p>
                </div>

                <div class="col-span-2 p-4 bg-purple-50 rounded-lg shadow text-center">
                    <h3 class="text-purple-700 font-semibold">Asistencia real</h3>
                    <p class="text-2xl font-bold text-purple-900">
                        {{ $porcentajeAsistencia }}%
                    </p>
                </div>

            </div>

        </div>

        <!-- TABLA: INSCRITOS -->
        <div class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Listado de Inscritos</h2>

            @if($inscritos->count() == 0)
                <p class="text-gray-500">No hay estudiantes inscritos.</p>
            @else
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Alumno</th>
                            <th class="px-4 py-2 text-left">Correo</th>
                            <th class="px-4 py-2 text-left">Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inscritos as $r)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $r->user->name }}</td>
                                <td class="px-4 py-2">{{ $r->user->email }}</td>
                                <td class="px-4 py-2">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- TABLA: ASISTENCIAS -->
        <div class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Asistencias Registradas</h2>

            @if($asistencias->count() == 0)
                <p class="text-gray-500">No hay asistencias registradas.</p>
            @else
                <table class="min-w-full border">
                    <thead class="bg-green-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Alumno</th>
                            <th class="px-4 py-2 text-left">Correo</th>
                            <th class="px-4 py-2 text-left">Fecha y Hora</th>
                            <th class="px-4 py-2 text-left">Confirmado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asistencias as $a)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $a->registro->user->name }}</td>
                                <td class="px-4 py-2">{{ $a->registro->user->email }}</td>
                                <td class="px-4 py-2">
                                    {{ date('d/m/Y H:i', strtotime($a->fecha_asistencia)) }}
                                </td>
                                <td class="px-4 py-2">{{ $a->confirmado_por }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- TABLA: CANCELADOS -->
        <div class="bg-white p-6 rounded-xl shadow mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Inscripciones Canceladas</h2>

            @if($cancelados->count() == 0)
                <p class="text-gray-500">No hay cancelaciones.</p>
            @else
                <table class="min-w-full border">
                    <thead class="bg-red-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Alumno</th>
                            <th class="px-4 py-2 text-left">Correo</th>
                            <th class="px-4 py-2 text-left">Fecha Cancelación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cancelados as $c)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $c->user->name }}</td>
                                <td class="px-4 py-2">{{ $c->user->email }}</td>
                                <td class="px-4 py-2">{{ $c->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>

@endsection