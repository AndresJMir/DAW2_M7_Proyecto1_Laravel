<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => File::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */ 
    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);
        // Desar fitxer al disc i inserir dades a BD
        $upload = $request->file('upload');
        $file = new File();
        $ok = $file->diskSave($upload);


        if ($ok) {
            return response()->json([
                'success'  => true,
                'message' => 'Añadido',
                'data'    => File::all()
            ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el archivo por su ID
        $file = File::find($id);

        if ($file){
            return response()->json([
                'success'  => true,
                'message' => 'Perfe show'
            ], 200);}
        else {
            return response()->json([
                'success'  => false,
                'message' => 'Fail show'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar el archivo por su ID
        $file = File::find($id);

        if ($file){
            // Validar fitxer
            $validatedData = $request->validate([
                'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
            ]);
            // Actualizar el archivo
            $file->name = $validatedData['name'] ?? $file->name;
            $file->description = $validatedData['description'] ?? $file->description;
            $file->save();
            // Funciona
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Fail show'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        // Buscar el archivo por su ID
        $file = File::find($id);
        if ($file){
            $file->delete();
            return response()->json([
                'success'  => true,
                'message' => 'File deleted'
            ], 200);}
        else {
            return response()->json([
                'success'  => false,
                'message' => 'File NOT deleted'
            ], 404);
        }
    }
}
