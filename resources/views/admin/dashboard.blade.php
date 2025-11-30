@extends('layouts.app')

@section('content')

    <h1 class="text-3xl font-bold text-blue-800 mb-6">Dashboard Administrativo</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h3 class="text-sm text-gray-500">Total de Eventos</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $totalEventos }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h3 class="text-sm text-gray-500">Categorías</h3>
            <p class="text-3xl font-bold text-green-600">{{ $totalCategorias }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h3 class="text-sm text-gray-500">Cupo Total</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $totalCupo }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h3 class="text-sm text-gray-500">Estudiantes Inscritos</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $totalEstudiantes }}</p>
        </div>

    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="font-bold mb-3 text-lg">Eventos por Categoría</h2>
            <canvas id="chartCategorias"></canvas>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="font-bold mb-3 text-lg">Eventos por Mes</h2>
            <canvas id="chartMes"></canvas>
        </div>

        <div class="bg-white p-6 rounded-xl shadow lg:col-span-2">
            <h2 class="font-bold mb-3 text-lg">Cupo por Categoría</h2>
            <div class="flex justify-center">
                <canvas id="chartCupo" style="max-width: 300px; max-height: 300px;"></canvas>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Categorías
        new Chart(document.getElementById('chartCategorias'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsCategorias) !!},
                datasets: [{
                    label: 'Eventos',
                    data: {!! json_encode($dataCategorias) !!},
                    backgroundColor: '#2563eb'
                }]
            }
        });

        // Meses
        new Chart(document.getElementById('chartMes'), {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsMes) !!},
                datasets: [{
                    label: 'Eventos',
                    data: {!! json_encode($dataMes) !!},
                    borderColor: '#16a34a',
                    fill: false
                }]
            }
        });

        // Cupo por categoría
        new Chart(document.getElementById('chartCupo'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labelsCupo) !!},
                datasets: [{
                    data: {!! json_encode($dataCupo) !!},
                    backgroundColor: ['#2563eb', '#16a34a', '#eab308', '#dc2626', '#9333ea'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%', // hace el donut más pequeño y elegante
            }
        });

    </script>

@endsection