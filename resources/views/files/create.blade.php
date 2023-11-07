@extends('layouts.app')
@section('content') 
<h2 class="text-2xl font-bold mb-4">Añadir Archivo:</h2>
<form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
   @csrf
   <div class="form-group">
       <label for="upload">File:</label>
       <input type="file" class="form-control" name="upload"/>
   </div>
   <button type="submit" class="btn btn-primary bg-blue-500 text-white">Create</button>
   <button type="reset" class="btn btn-secondary bg-red-500 text-white">Reset</button>
</form>
@endsection
