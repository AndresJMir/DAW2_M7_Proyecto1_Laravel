<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Crud listing
        return view("files.index", [
            "files" => File::all()
        ]);
 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("files.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validar fitxer
       $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
    ]);
   
    // Obtenir dades del fitxer
    $upload = $request->file('upload');
    $fileName = $upload->getClientOriginalName();
    $fileSize = $upload->getSize();
    Log::debug("Storing file '{$fileName}' ($fileSize)...");


    // Pujar fitxer al disc dur
    $uploadName = time() . '_' . $fileName;
    $filePath = $upload->storeAs(
        'uploads',      // Path
        $uploadName ,   // Filename
        'public'        // Disk
    );
   
    if (Storage::disk('public')->exists($filePath)) {
        Log::debug("Disk storage OK");
        $fullPath = Storage::disk('public')->path($filePath);
        Log::debug("File saved at {$fullPath}");
        // Desar dades a BD
        $file = File::create([
            'filepath' => $filePath,
            'filesize' => $fileSize,
        ]);
        Log::debug("DB storage OK");
        // Patró PRG amb missatge d'èxit
        return redirect()->route('files.show', $file)
            ->with('success', 'File successfully saved');
    } else {
        Log::debug("Disk storage FAILS");
        // Patró PRG amb missatge d'error
        return redirect()->route("files.create")
            ->with('error', 'ERROR uploading file');
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        // Verificar si el archivo existe en el disco
        if (Storage::disk('public')->exists($file->filepath)) {
            // Obtener la ruta completa del archivo
            $filePath = Storage::disk('public')->path($file->filepath);
            
            // Mostrar los datos del archivo y la imagen en una vista
            return view('files.show', [
                'file' => $file,
                'filePath' => $filePath
            ]);
        } else {
            // Redirigir a la página de índice con un mensaje flash de error
            return redirect()->route('files.index')->with('error', 'El archivo no existe');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
        return view('files.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //

        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
          ]);
        
          // Eliminar archivo anterior
          Storage::disk('public')->delete($file->filepath);
        
          // Nuevo archivo
          $upload = $request->file('upload');
          $fileName = $upload->getClientOriginalName();
          $fileSize = $upload->getSize();
        
          // Guardar archivo
          $uploadName = time() . '_' . $fileName;
          $filePath = $upload->storeAs(
            'uploads', 
            $uploadName,
            'public'
          );
        
          // Actualizar BD
          if(Storage::disk('public')->exists($filePath)) {
        
            $file->update([
              'filepath' => $filePath,
              'filesize' => $fileSize
            ]);
        
            return redirect()->route('files.show', $file)
              ->with('success', 'File updated');
        
          } else {
        
            return redirect()->back()
              ->withErrors('Error updating file');
        
          }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        // Eliminar archivo del disco
        if(Storage::disk('public')->delete($file->filepath)) {
            
            // Eliminar registro de BD
            if($file->delete()) {

            // Redirección con mensaje flash
            return redirect()->route('files.index')->with('success', 'File deleted successfully');
            
            } else {
            
            return redirect()->route('files.show', $file)->with('error', 'Error deleting file record');
            
            }

        } else {

            return redirect()->route('files.show', $file)->with('error', 'Error deleting file');

        }
    }
}
