@extends('layouts.app')

@section('content')
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-700">Gestión de Eventos</h1>
            <a href="{{ route('eventos.create') }}"
                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                + Crear Evento
            </a>
        </div>

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="mb-4 p-3 text-green-800 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- DataTable --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table id="eventosTabla" class="min-w-full text-left">

                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3">Título</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Hora</th>
                        <th class="px-4 py-3">Lugar</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($eventos as $evento)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $evento->titulo }}</td>
                            <td class="px-4 py-3">{{ $evento->categoria->nombre }}</td>
                            <td class="px-4 py-3">{{ $evento->fecha }}</td>
                            <td class="px-4 py-3">{{ $evento->hora_inicio }} - {{ $evento->hora_fin }}</td>
                            <td class="px-4 py-3">{{ $evento->lugar }}</td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-3">

                                    {{-- 🔵 VER REPORTE --}}
                                    <a href="{{ route('eventos.show', $evento->id) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Ver reporte
                                    </a>

                                    {{-- 🔵 EDITAR --}}
                                    <button type="button" onclick="openEditModal({{ $evento }})"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Editar
                                    </button>

                                    {{-- 🔵 ELIMINAR --}}
                                    <form id="deleteForm-{{ $evento->id }}" action="{{ route('eventos.destroy', $evento->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $evento->id }})"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        {{-- ------------------------ --}}
        {{-- 💾 PASAR CATEGORÍAS AL JS --}}
        {{-- ------------------------ --}}
        <script>
            const categorias = @json($categorias);
        </script>

        {{-- ------------------------ --}}
        {{-- DATATABLE --}}
        {{-- ------------------------ --}}
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
        <script>
            new DataTable('#eventosTabla', {
                searchable: true,
                perPage: 10,
            });
        </script>

        {{-- ------------------------ --}}
        {{-- CONFIRMAR ELIMINACIÓN --}}
        {{-- ------------------------ --}}
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: '¿Eliminar evento?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteForm-' + id).submit();
                    }
                });
            }
        </script>

        {{-- ------------------------ --}}
        {{-- ✏️ MODAL EDITAR EVENTO --}}
        {{-- ------------------------ --}}
        <script>
            function openEditModal(evento) {

                let opciones = categorias.map(cat => `
                <option value="${cat.id}" ${cat.id === evento.categoria_id ? 'selected' : ''}>
                    ${cat.nombre}
                </option>
            `).join('');

                Swal.fire({
                    title: `
                    <div style="font-weight:900; color:#002147;">
                        ✏️ Editar Evento
                    </div>
                `,
                    width: "780px",
                    background: "#f8fafc",
                    showClass: {
                        popup: `
                        animate__animated
                        animate__fadeInDown
                        animate__faster
                    `
                    },
                    html: `
                    <div class="siceu-card-anim">

                        <!-- GRID -->
                        <div class="siceu-grid">

                            <!-- TÍTULO -->
                            <div class="siceu-field">
                                <label class="siceu-label">Título</label>
                                <div class="siceu-icon-input">
                                    <svg class="siceu-icon"><use href="#academic-cap" /></svg>
                                    <input id="swal-titulo" class="siceu-input" value="${evento.titulo}">
                                </div>
                            </div>

                            <!-- LUGAR -->
                            <div class="siceu-field">
                                <label class="siceu-label">Lugar</label>
                                <div class="siceu-icon-input">
                                    <svg class="siceu-icon"><use href="#map-pin" /></svg>
                                    <input id="swal-lugar" class="siceu-input" value="${evento.lugar}">
                                </div>
                            </div>

                            <!-- DESCRIPCIÓN -->
                            <div class="siceu-field-full">
                                <label class="siceu-label">Descripción</label>
                                <textarea id="swal-descripcion" class="siceu-input textarea">${evento.descripcion ?? ''}</textarea>
                            </div>

                            <!-- FECHA -->
                            <div class="siceu-field">
                                <label class="siceu-label">Fecha</label>
                                <input id="swal-fecha" type="date" class="siceu-input" value="${evento.fecha}">
                            </div>

                            <!-- HORA INICIO -->
                            <div class="siceu-field">
                                <label class="siceu-label">Hora Inicio</label>
                                <input id="swal-hora-inicio" type="time" class="siceu-input" value="${evento.hora_inicio}">
                            </div>

                            <!-- HORA FIN -->
                            <div class="siceu-field">
                                <label class="siceu-label">Hora Fin</label>
                                <input id="swal-hora-fin" type="time" class="siceu-input" value="${evento.hora_fin}">
                            </div>

                            <!-- CUPO -->
                            <div class="siceu-field">
                                <label class="siceu-label">Cupo Máximo</label>
                                <input id="swal-cupo" type="number" min="1" class="siceu-input" value="${evento.cupo_max}">
                            </div>

                            <!-- CATEGORÍA -->
                            <div class="siceu-field">
                                <label class="siceu-label">Categoría</label>
                                <select id="swal-categoria" class="siceu-input">
                                    ${opciones}
                                </select>
                            </div>

                        </div>
                    </div>
                `,

                    showCancelButton: true,
                    confirmButtonText: "💾 Guardar Cambios",
                    cancelButtonText: "Cancelar",

                    customClass: {
                        popup: "siceu-popup-anim",
                        confirmButton: "btn-siceu-confirm",
                        cancelButton: "btn-siceu-cancel"
                    },

                    preConfirm: () => {

                        let titulo = document.getElementById("swal-titulo").value.trim();
                        let lugar = document.getElementById("swal-lugar").value.trim();
                        let fecha = document.getElementById("swal-fecha").value;
                        let horaInicio = document.getElementById("swal-hora-inicio").value;
                        let horaFin = document.getElementById("swal-hora-fin").value;

                        if (!titulo || !lugar || !fecha || !horaInicio || !horaFin) {
                            Swal.showValidationMessage("Todos los campos obligatorios deben estar llenos");
                            return false;
                        }

                        if (horaFin <= horaInicio) {
                            Swal.showValidationMessage("La hora de fin debe ser mayor a la de inicio");
                            return false;
                        }

                        return {
                            titulo: titulo,
                            descripcion: document.getElementById("swal-descripcion").value,
                            fecha: fecha,
                            hora_inicio: horaInicio,
                            hora_fin: horaFin,
                            lugar: lugar,
                            cupo_max: document.getElementById("swal-cupo").value,
                            categoria_id: document.getElementById("swal-categoria").value,
                        }
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        sendUpdate(evento.id, result.value);
                    }
                });
            }

            function sendUpdate(id, data) {
                fetch(`/eventos/${id}`, {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                }).then(() => {
                    Swal.fire({
                        icon: "success",
                        title: "Cambios guardados",
                        text: "El evento se actualizó correctamente.",
                        confirmButtonColor: "#006847"
                    }).then(() => location.reload());
                });
            }
        </script>

        <style>
            /* POPUP */
            .siceu-popup-anim {
                border-radius: 18px !important;
                border: 3px solid #e2e8f0 !important;
            }

            /* CARD */
            .siceu-card-anim {
                padding: 22px;
                border-radius: 18px;
                background: white;
                box-shadow:
                    0 4px 14px rgba(0, 0, 0, 0.08),
                    inset 0 0 12px rgba(0, 0, 0, 0.04);
            }

            /* GRID */
            .siceu-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .siceu-field-full {
                grid-column: span 2;
            }

            /* LABEL */
            .siceu-label {
                font-weight: 700;
                font-size: 14px;
                color: #002147;
                margin-bottom: 4px;
                display: block;
            }

            /* INPUT WRAPPER CON ICONO */
            .siceu-icon-input {
                position: relative;
            }

            .siceu-icon {
                width: 20px;
                opacity: 0.6;
                position: absolute;
                left: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: #002147;
            }

            /* INPUT */
            .siceu-input {
                width: 100%;
                padding: 10px 14px 10px 40px;
                border-radius: 10px;
                border: 2px solid #dce3ec;
                font-size: 14px;
                background: white;
                color: #002147;
                transition: 0.25s ease-in-out;
            }

            .siceu-input:focus {
                border-color: #006847 !important;
                box-shadow: 0 0 10px rgba(0, 104, 71, 0.35);
                outline: none;
            }

            .textarea {
                resize: none;
                padding-left: 14px !important;
            }

            /* BOTONES */
            .btn-siceu-confirm {
                background-color: #006847 !important;
                font-weight: 800 !important;
                border-radius: 10px !important;
                padding: 12px 26px !important;
            }

            .btn-siceu-confirm:hover {
                background-color: #004d33 !important;
            }

            .btn-siceu-cancel {
                background-color: #cbd5e1 !important;
                color: #1e293b !important;
                border-radius: 10px !important;
                padding: 12px 26px !important;
            }

            .btn-siceu-cancel:hover {
                background-color: #b8c3d1 !important;
            }
        </style>



@endsection