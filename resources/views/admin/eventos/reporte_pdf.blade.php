<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte - {{ $evento->titulo }}</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        h1 { font-size: 20px; }
    </style>
</head>

<body>

<h1>{{ $evento->titulo }}</h1>
<p><strong>Fecha:</strong> {{ $evento->fecha }}</p>
<p><strong>Lugar:</strong> {{ $evento->lugar }}</p>

<h3>Lista de Asistentes</h3>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Registrado</th>
            <th>Asistió</th>
        </tr>
    </thead>

    <tbody>
        @foreach($registros as $r)
            @php
                $asistio = $asistencias->contains('registro_id', $r->id);
            @endphp

            <tr>
                <td>{{ $r->user->name ?? 'N/A' }}</td>
                <td>{{ $r->user->email ?? 'N/A' }}</td>
                <td>{{ strtoupper($r->estado) }}</td>
                <td>{{ $asistio ? 'SÍ' : 'NO' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
