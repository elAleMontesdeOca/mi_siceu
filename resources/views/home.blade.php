<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SICEU - Sistema de Control de Eventos Universitarios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fuente profesional -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
</head>

<body class="bg-gradient-to-br from-blue-700 via-blue-800 to-blue-900 min-h-screen flex flex-col font-inter">

    <!-- NAVBAR DUAL -->
    <nav
        class="w-full px-8 py-4 flex justify-between items-center bg-white/90 backdrop-blur shadow-lg border-b-2 border-blue-600">
        <div class="flex items-center gap-3">
            <img src="/logo_siceu.png" class="h-10" alt="Logo SICEU"> <!-- opcional -->
            <h1 class="text-2xl font-extrabold text-blue-700 tracking-wide">SICEU</h1>
        </div>

        <div class="space-x-3">
            <a href="/login"
                class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                Iniciar Sesión
            </a>

            <a href="/register"
                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                Registrarse
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <header class="flex flex-1 flex-col items-center justify-center text-center text-white px-6 py-20">

        <h2 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg">
            Bienvenido a <span class="text-green-300">SICEU</span>
        </h2>

        <p class="text-xl md:text-2xl max-w-3xl mb-10 opacity-95 leading-relaxed">
            El sistema universitario moderno para gestionar, administrar y participar en eventos
            académicos, culturales y formativos.
        </p>

        <div class="flex gap-4 mt-4">
            <a href="/login"
                class="px-8 py-3 bg-white text-blue-700 font-bold rounded-lg shadow-lg hover:bg-gray-100 transition duration-200">
                Iniciar Sesión
            </a>

            <a href="/register"
                class="px-8 py-3 bg-green-600 text-white font-bold rounded-lg shadow-lg hover:bg-green-700 transition duration-200">
                Crear Cuenta
            </a>
        </div>

        <!-- Indicador -->
        <div class="mt-12 animate-bounce">
            <span class="text-white/70 text-sm">Desliza hacia abajo</span>
        </div>

    </header>

    <!-- SECCIÓN DE EVENTOS DESTACADOS -->
    <section class="bg-white w-full py-16 px-6 shadow-inner">

        <h3 class="text-3xl font-extrabold text-center text-blue-800 mb-10">
            🎓 Eventos Destacados
        </h3>

        <!-- SECCIÓN DE EVENTOS DESTACADOS -->
        <section class="bg-white w-full py-16 px-6 shadow-inner">

            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

                @forelse($eventosDestacados as $ev)
                    <div class="p-6 rounded-xl border border-blue-200 shadow-lg bg-white hover:shadow-xl transition">
                        <h4 class="font-bold text-blue-700 text-xl mb-2">{{ $ev->titulo }}</h4>

                        <p class="text-gray-600 line-clamp-3 mb-4">
                            {{ $ev->descripcion ?? 'Evento universitario.' }}
                        </p>

                        <span class="text-green-600 font-semibold block">
                            📅 {{ \Carbon\Carbon::parse($ev->fecha)->format('d M Y') }}
                        </span>

                        <span class="text-blue-700 text-sm block">
                            🕒 {{ $ev->hora_inicio }} - {{ $ev->hora_fin }}
                        </span>

                        <span class="text-gray-700 text-sm block mt-1">
                            📍 {{ $ev->lugar }}
                        </span>

                        <a href="/eventos/{{ $ev->id }}"
                            class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Ver detalles
                        </a>
                    </div>
                @empty
                    <p class="text-center text-gray-600 col-span-3">
                        No hay eventos disponibles aún.
                    </p>
                @endforelse

            </div>
        </section>

    </section>

    <!-- FOOTER -->
    <footer class="w-full py-6 text-center text-white/80 bg-blue-900 mt-10 border-t border-blue-700">
        <p class="text-sm">
            © {{ date('Y') }} SICEU - Sistema de Control de Eventos Universitarios.
            <br>UTTEC | Todos los derechos reservados - Equipo de Desarrollo AURÉA
        </p>
    </footer>

</body>

</html>