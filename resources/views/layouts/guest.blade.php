<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SICEU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    @yield('content')
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