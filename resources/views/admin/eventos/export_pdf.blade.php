<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte del Evento</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
            font-size: 13px;
            color: #1a1a1a;
        }

        h1,
        h2,
        h3 {
            color: #004085;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .section-title {
            background: #eef3f9;
            padding: 8px;
            font-weight: bold;
            border-left: 5px solid #0056b3;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 18px;
        }

        table thead {
            background: #e5e5e5;
        }

        table th,
        table td {
            border: 1px solid #bbb;
            padding: 6px 8px;
            text-align: left;
            font-size: 12px;
        }

        .stats-box {
            padding: 10px;
            border: 1px solid #ccd;
            background: #fafafa;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>SICEU – Reporte de Evento</h1>
        <p><strong>{{ $evento->titulo }}</strong></p>
        <p>{{ date('d/m/Y') }}</p>
    </div>

    <!-- Información del Evento -->
    <div class="section-title">Datos del Evento</div>
    <table>
        <tr>
            <th>Categoría</th>
            <td>{{ $evento->categoria->nombre }}</td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td>{{ date('d/m/Y', strtotime($evento->fecha)) }}</td>
        </tr>
        <tr>
            <th>Horario</th>
            <td>{{ $evento->hora_inicio }} - {{ $evento->hora_fin }}</td>
        </tr>
        <tr>
            <th>Lugar</th>
            <td>{{ $evento->lugar }}</td>
        </tr>
        <tr>
            <th>Cupo Máximo</th>
            <td>{{ $evento->cupo_max }}</td>
        </tr>
    </table>

    <!-- Estadísticas -->
    <div class="section-title">Estadísticas Generales</div>

    <div class="stats-box">
        <p><strong>Total inscritos:</strong> {{ $totalInscritos }}</p>
        <p><strong>Total asistencias:</strong> {{ $totalAsistencias }}</p>
        <p><strong>Total cancelados:</strong> {{ $totalCancelados }}</p>
        <p><strong>Cupo ocupado:</strong> {{ $porcentajeOcupado }}%</p>
        <p><strong>Asistencia real:</strong> {{ $porcentajeAsistencia }}%</p>
    </div>

    <!-- Inscritos -->
    <div class="section-title">Listado de Inscritos</div>

    @if($inscritos->count() == 0)
        <p>No hay inscritos registrados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Correo</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscritos as $r)
                    <tr>
                        <td>{{ $r->user->name }}</td>
                        <td>{{ $r->user->email }}</td>
                        <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Asistencias -->
    <div class="section-title">Asistencias Registradas</div>

    @if($asistencias->count() == 0)
        <p>No hay asistencias registradas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Correo</th>
                    <th>Fecha y Hora</th>
                    <th>Confirmado por</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asistencias as $a)
                    <tr>
                        <td>{{ $a->registro->user->name }}</td>
                        <td>{{ $a->registro->user->email }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($a->fecha_asistencia)) }}</td>
                        <td>{{ $a->confirmado_por }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Cancelados -->
    <div class="section-title">Inscripciones Canceladas</div>

    @if($cancelados->count() == 0)
        <p>No hay cancelaciones.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Correo</th>
                    <th>Fecha Cancelación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cancelados as $c)
                    <tr>
                        <td>{{ $c->user->name }}</td>
                        <td>{{ $c->user->email }}</td>
                        <td>{{ $c->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    <!-- Footer -->
    <div class="footer">
        <p>SICEU – Sistema de Control de Eventos Universitarios</p>
        <p>Reporte generado automáticamente</p>
    </div>

</body>

</html>