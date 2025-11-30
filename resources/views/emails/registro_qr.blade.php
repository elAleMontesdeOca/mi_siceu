@component('mail::message')

# Registro Confirmado

Te has registrado exitosamente al evento:

**{{ $evento->titulo }}**

Fecha: **{{ date('d/m/Y', strtotime($evento->fecha)) }}**
Horario: **{{ $evento->hora_inicio }} - {{ $evento->hora_fin }}**
Lugar: **{{ $evento->lugar }}**

---

## 🎟 Tu código QR para confirmar asistencia:

<img src="data:image/svg+xml;base64,{{ $qrBase64 }}" style="width:200px; display:block; margin:auto;">

---

¡Presenta este código en el evento para registrar tu asistencia!

Gracias por usar **SICEU**.

@endcomponent