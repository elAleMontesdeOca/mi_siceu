@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-3xl mx-auto">

        <h1 class="text-3xl font-bold text-blue-700 mb-6">Crear Evento</h1>
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg shadow">
                <div class="flex items-center mb-2">
                    <span class="text-xl mr-2">⚠️</span>
                    <h3 class="font-bold text-lg">Se encontraron errores en el formulario:</h3>
                </div>

                <ul class="list-disc pl-6 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <div class="bg-white shadow rounded-xl p-6">

            <form method="POST" action="{{ route('eventos.store') }}">
                @csrf

                <div class="grid grid-cols-1 gap-5">

                    <div>
                        <label class="font-semibold text-gray-700">Título</label>
                        <input type="text" name="titulo" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Descripción</label>
                        <textarea name="descripcion" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Fecha</label>
                            <input type="date" name="fecha" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Hora Inicio</label>
                            <input type="time" name="hora_inicio" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Hora Fin</label>
                            <input type="time" name="hora_fin" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Lugar</label>
                        <input name="lugar" required type="text"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Cupo Máximo</label>
                        <input type="number" name="cupo_max" min="1" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Categoría</label>
                        <select name="categoria_id" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="flex justify-between mt-6">
                    <a href="{{ route('eventos.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Cancelar
                    </a>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Guardar Evento
                    </button>
                </div>

            </form>

        </div>

    </div>
@endsection