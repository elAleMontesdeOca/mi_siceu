@extends('layouts.estudiante')

@section('content')

<h1 class="text-3xl font-bold text-blue-800 mb-6">Notificaciones</h1>

@if($notificaciones->count() == 0)
    <div class="bg-white shadow p-8 rounded-xl text-center">
        <h2 class="text-xl font-semibold text-gray-700">No tienes notificaciones</h2>
        <p class="text-gray-500 mt-2">Aquí aparecerán recordatorios y avisos importantes.</p>
    </div>
@endif

<div class="space-y-4">

    @foreach($notificaciones as $n)
    <div class="bg-white shadow rounded-xl p-5 border-l-4 
        @if($n->tipo == 'recordatorio') border-blue-600 @else border-gray-400 @endif">

        <h2 class="text-lg font-semibold text-gray-800">{{ $n->titulo }}</h2>

        <p class="text-gray-600 mt-1">{{ $n->mensaje }}</p>

        <div class="mt-3 flex items-center gap-3 text-gray-500 text-sm">
            <svg class="w-5 h-5"><use href="#calendar-days" /></svg>
            <span>{{ date('d/m/Y H:i', strtotime($n->fecha_envio)) }}</span>

            <span class="px-2 py-1 rounded-full text-xs
                @if($n->tipo == 'recordatorio') bg-blue-100 text-blue-700 
                @else bg-gray-200 text-gray-700 @endif">
                {{ ucfirst($n->tipo) }}
            </span>
        </div>

    </div>
    @endforeach

</div>

@endsection
