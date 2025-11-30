<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICEU - Estudiante</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex bg-gray-100">

    <!-- ================== SVG ICONOS GLOBALES ================== -->
    <svg class="hidden">

        <!-- ICONO: Academic Cap -->
        <symbol id="academic-cap" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 14l9-5-9-5-9 5 9 5z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 14v5m0 0l4-2m-4 2l-4-2" />
        </symbol>

        <!-- ICONO: Calendario -->
        <symbol id="calendar-days" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 6.75h15a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 18.75V8.25a1.5 1.5 0 011.5-1.5z" />
        </symbol>

        <!-- ICONO: Bookmark -->
        <symbol id="bookmark" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                d="M6 3h12a2 2 0 012 2v16l-8-4-8 4V5a2 2 0 012-2z" />
        </symbol>

        <!-- ICONO: Bell (notificaciones) -->
        <symbol id="bell" viewBox="0 0 24 24" stroke="currentColor" fill="none">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M15 17h5l-1.4-1.4A2 2 0 0118 13.6V11a6 6 0 00-12 0v2.6a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0h6z" />
        </symbol>

        <!-- ICONO: Arrow Left (logout) -->
        <symbol id="arrow-left-on-rectangle" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"
                d="M9 8l-4 4m0 0l4 4m-4-4h12m-3 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v1" />
        </symbol>

    </svg>

    <!-- ================== SIDEBAR ================== -->
    <aside class="w-64 bg-white shadow-xl h-screen fixed left-0 top-0 z-40 transition">

        <!-- LOGO Y TITULO -->
        <div class="p-6 border-b flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-600">
                <use href="#academic-cap" />
            </svg>
            <div>
                <h1 class="text-xl font-bold text-blue-700">SICEU</h1>
                <p class="text-xs text-gray-500">Panel Estudiante</p>
            </div>
        </div>

        <!-- MENU -->
        <nav class="p-4 space-y-1">

            <a href="/estudiante/eventos"
                class="flex items-center gap-3 px-4 py-2 rounded-lg transition text-gray-700 hover:bg-gray-100">
                <svg class="w-6 h-6">
                    <use href="#calendar-days" />
                </svg>
                <span>Eventos Activos</span>
            </a>

            <a href="{{ route('estudiante.mis-eventos') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg transition text-gray-700 hover:bg-gray-100">
                <svg class="w-6 h-6">
                    <use href="#bookmark" />
                </svg>
                <span>Mis Eventos</span>
            </a>


            <!-- CONTADOR DE NOTIFICACIONES -->
            @php
                $user = Auth::user();
                $cantidad = \App\Models\Notificacion::whereIn(
                    'evento_id',
                    \App\Models\Registro::where('user_id', $user->id)->pluck('evento_id')
                )->count();
            @endphp

            <a href="{{ route('estudiante.notificaciones') }}"
                class="flex items-center justify-between px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">

                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6">
                        <use href="#bell" />
                    </svg>
                    <span>Notificaciones</span>
                </div>

                @if($cantidad > 0)
                    <span class="px-2 py-1 text-xs bg-red-600 text-white rounded-full">
                        {{ $cantidad }}
                    </span>
                @endif
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="absolute bottom-0 w-full p-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <svg class="w-5 h-5">
                        <use href="#arrow-left-on-rectangle" />
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>

    </aside>

    <!-- ================== CONTENIDO ================== -->
    <main class="flex-1 ml-64 p-6">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif

</body>

</html>