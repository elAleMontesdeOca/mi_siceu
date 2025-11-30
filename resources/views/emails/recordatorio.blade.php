@component('mail::message')

# Recordatorio de Evento

Hola **{{ $user->name }}**,

Te recordamos que mañana tienes el evento:

**{{ $evento->titulo }}**

📅 Fecha: **{{ date('d/m/Y', strtotime($evento->fecha)) }}**
🕒 Horario: **{{ $evento->hora_inicio }} - {{ $evento->hora_fin }}**
📍 Lugar: **{{ $evento->lugar }}**

¡Te esperamos!

@endcomponent