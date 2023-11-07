@extends('layouts.app')
@section('content') 
    <div>
        <h2 class="text-2xl font-bold mb-4">Archivo seleccionado:</h2>
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">id</th>
                    <th class="py-2 px-4 border-b">Miniatura</th>
                    <th class="py-2 px-4 border-b">Ruta</th>
                    <th class="py-2 px-4 border-b">Tamaño</th>
                    <th class="py-2 px-4 border-b">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 px-4 border-b">{{ $file->id }}</td>
                    <td class="py-2 px-4 border-b"><img class="img-fluid" src='{{ asset("storage/{$file->filepath}") }}' /></td>
                    <td class="py-2 px-4 border-b">{{ $file->filepath }}</td>
                    <td class="py-2 px-4 border-b">{{ $file->filesize }}</td>
                    <td class="py-2 px-4 border-b">{{ $file->created_at }}</td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-2xl font-bold mb-4">Inserta la nueva imagen:</h2>
        <form class="space-y-6" action="{{ route('files.update', $file) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Campos del formulario -->

            <div class="flex items-center">
                <label class="block text-sm font-medium text-gray-700">
                    Imagen
                </label>
                <input 
                    type="file" name="upload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
            </div>
            <button type="submit" class="group relative w-full flex justify-center py-2 px-4 bg-green-500 text-white rounded hover:bg-green-700 mb-4">
                Actualizar
            </button>
        </form>
        <table class="min-w-full bg-white border-collapse">
            <tfoot>
            </tfoot>
        </table>
    </div>
@endsection
