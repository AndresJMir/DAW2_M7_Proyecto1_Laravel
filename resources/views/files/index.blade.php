@extends('layouts.app')
<!-- http://localhost:8001/files
Session iniciada
INICIAR LOS 2!!
npm run dev
php artisan serve
 -->
@section('content') 
    <div>
        <h2 class="text-2xl font-bold mb-4">Lista de Archivos</h2>
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">id</th>
                    <th class="py-2 px-4 border-b">Miniatura</th>
                    <th class="py-2 px-4 border-b">Ruta</th>
                    <th class="py-2 px-4 border-b">Tamaño</th>
                    <th class="py-2 px-4 border-b">Fecha</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $file->id }}</td>
                        <td class="py-2 px-4 border-b"><img class="img-fluid" src='{{ asset("storage/{$file->filepath}") }}' /></td>
                        <td class="py-2 px-4 border-b">{{ $file->filepath }}</td>
                        <td class="py-2 px-4 border-b">{{ $file->filesize }}</td>
                        <td class="py-2 px-4 border-b">{{ $file->created_at }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('files.show', $file->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-700">Ver</a>
                            <a href="{{ route('files.edit', $file->id) }}" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-700">Editar</a>
                            <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-700">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('files.create') }}" class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-700 mb-4">Crear Archivo</a>
    </div>
    @endsection