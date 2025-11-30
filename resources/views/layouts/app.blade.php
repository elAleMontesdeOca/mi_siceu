<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICEU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/heroicons@2.1.1/outline/24/index.js"></script>
</head>

<body class="flex bg-gray-100">
    <!-- HEROICONS OUTLINE SPRITE -->
    <svg xmlns="http://www.w3.org/2000/svg" class="hidden">

        <!-- CLOCK -->
        <symbol id="clock" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M12 6v6l4 2M12 2.25A9.75 9.75 0 112.25 12 9.76 9.76 0 0112 2.25z" />
        </symbol>

        <!-- MAP PIN -->
        <symbol id="map-pin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M12 21s-7.5-5.25-7.5-12A7.5 7.5 0 1119.5 9c0 6.75-7.5 12-7.5 12z" />
            <circle cx="12" cy="9" r="3" stroke-width="1.8" />
        </symbol>

        <!-- HOME -->
        <symbol id="home" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M2.25 12l9.75-9 9.75 9M4.5 9.75v10.5A2.25 2.25 0 006.75 22.5h10.5a2.25 2.25 0 002.25-2.25V9.75" />
        </symbol>

        <!-- ACADEMIC CAP -->
        <symbol id="academic-cap" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M12 14.25L1.5 9l10.5-5.25L22.5 9 12 14.25z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M6 10.5v4.5c0 2.485 2.239 4.5 5 4.5s5-2.015 5-4.5v-4.5" />
        </symbol>

        <!-- CALENDAR DAYS -->
        <symbol id="calendar-days" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M6.75 3v2.25M17.25 3v2.25M3.75 7.5h16.5M4.5 9.75v8.25A2.25 2.25 0 006.75 20.25h10.5A2.25 2.25 0 0019.5 18V9.75" />
        </symbol>

        <!-- TAG -->
        <symbol id="tag" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M7.5 4.5h4.75L21 13l-6.75 6.75-8.75-8.75V4.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 7.5h.01" />
        </symbol>

        <!-- USERS -->
        <symbol id="users" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M17 20.25v-1.5a4 4 0 00-4-4H6a4 4 0 00-4 4v1.5" />
            <circle cx="9" cy="9" r="4.5" stroke-width="1.8" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M22.5 20.25v-1.5a4 4 0 00-3-3.87" />
            <circle cx="19.5" cy="9" r="3" stroke-width="1.8" />
        </symbol>

        <!-- LOGOUT -->
        <symbol id="arrow-left-on-rectangle" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.75 9l3 3-3 3M21.75 12H9" />
        </symbol>

    </svg>


    <!-- SIDEBAR -->
    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="w-64 bg-white shadow-xl h-screen fixed left-0 top-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300">

        <div class="p-6 border-b flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8">
                <use href="#academic-cap" />
            </svg>
            <div>
                <h1 class="text-xl font-bold text-blue-700">SICEU</h1>
                <p class="text-xs text-gray-500">Panel Administrativo</p>
            </div>
        </div>

        <nav class="p-4 space-y-1">

            <a href="/admin/dashboard"
                class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->is('admin/dashboard') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-6 h-6">
                    <use href="#home" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('eventos.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->is('eventos*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-6 h-6">
                    <use href="#calendar-days" />
                </svg>
                Eventos
            </a>

            <a class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-500 opacity-60 cursor-not-allowed">
                <svg class="w-6 h-6">
                    <use href="#tag" />
                </svg>
                Categorías (Pronto)
            </a>

            <a class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-500 opacity-60 cursor-not-allowed">
                <svg class="w-6 h-6">
                    <use href="#users" />
                </svg>
                Usuarios (Pronto)
            </a>

            <a href="{{ route('admin.qr.scanner') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6">
                    <use href="#qr-code" />
                </svg>
                <span>Lector QR</span>
            </a>


        </nav>

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



    <!-- CONTENIDO PRINCIPAL -->
    <div class="flex-1 ml-0 md:ml-64 min-h-screen">

        <!-- TOPBAR -->
        <header class="flex items-center justify-between bg-white shadow px-4 py-3 md:hidden">
            <h2 class="text-xl font-semibold text-blue-700">SICEU</h2>
            <button onclick="toggleSidebar()" class="text-3xl">☰</button>
        </header>

        <main class="p-4 md:p-6">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });
        @endif

        @if($errors->any())
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: "Revisa los campos del formulario",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    </script>

    @if(session('modal_success'))
        <script>
            Swal.fire({
                title: "¡Éxito!",
                text: "{{ session('modal_success') }}",
                icon: "success",
                confirmButtonColor: "#2563eb"
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.16/outline"></script>

</body>

</html>