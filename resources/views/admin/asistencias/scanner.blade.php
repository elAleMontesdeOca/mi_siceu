@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-blue-800 mb-6">Lector de Código QR</h1>

<div class="bg-white shadow-xl p-6 rounded-xl">

    <p class="text-gray-600 mb-4">
        Apunta la cámara al código QR del estudiante para registrar su asistencia.
    </p>

    <!-- Contenedor del lector -->
    <div id="reader" style="width: 380px;" class="mx-auto mb-6"></div>

    <div id="result" class="text-center text-lg font-semibold text-gray-700"></div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const scanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: 250 }
    );

    scanner.render(onScanSuccess);

    function onScanSuccess(decodedText) {

        // Enviar el token al servidor
        fetch("{{ route('admin.qr.registrar') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ token: decodedText })
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Asistencia registrada",
                    text: data.estudiante + " – " + data.evento,
                    timer: 2500,
                    showConfirmButton: false,
                });
            }
            else if (data.status === "warning") {
                Swal.fire({
                    icon: "warning",
                    title: "Ya registrada",
                    text: data.message,
                    timer: 2500,
                    showConfirmButton: false,
                });
            }
            else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                    timer: 2500,
                    showConfirmButton: false,
                });
            }
        })
        .catch(err => {
            Swal.fire({
                icon: "error",
                title: "Fallo de lectura",
                text: "No se pudo procesar el código.",
                timer: 2500,
                showConfirmButton: false,
            });
        });
    }
</script>

@endsection
