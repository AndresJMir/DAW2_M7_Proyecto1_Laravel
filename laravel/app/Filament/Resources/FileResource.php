<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('filepath')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\FileUpload::make('filepath')//se cambia de entrada de texto a fichero de entrada
                ->required()//Hace que el campo sea requerido.
                ->image()//Solo se permiten imágenes.
                ->maxSize(2048)//Establece un límite máximo de tamaño de archivo de 2MB
                ->directory('uploads')//Define que los archivos se guardarán en el directorio "uploads"
                ->getUploadedFileNameForStorageUsing(function (Livewire\TemporaryUploadedFile $file): string {
                    return time() . '_' . $file->getClientOriginalName();
                }),//Sirve personalizar el nombre de archivo antes del almacenamiento.
                // Forms\Components\TextInput::make('filesize')
                //     ->required(),//Devuelve un nombre de archivo

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filepath'),
                Tables\Columns\TextColumn::make('filesize'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'view' => Pages\ViewFile::route('/{record}'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }    
}
