<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CocheResource\Pages;
use App\Models\Coche;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CocheResource extends Resource
{
    protected static ?string $model = Coche::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                
Forms\Components\FileUpload::make('imagenes_ruta')
    ->label('Imágenes')
    ->image()
    ->directory('coches')
    ->preserveFilenames()
    ->previewable()
        ->multiple()

    ->visibility('public')
    ->getUploadedFileNameForStorageUsing(fn ($file) => "coches/{$file->getClientOriginalName()}"),




                Forms\Components\Select::make('kit_id')
                    ->label('Kit')
                    ->relationship('kit', 'paquete')
                    ->required()
                    ->reactive(),

                Forms\Components\Select::make('caja_id')
                    ->label('Caja')
                    ->relationship('caja', 'tipo')
                    ->required()
                    ->reactive(),

                Forms\Components\Select::make('modelo_id')
                    ->label('Modelo')
                    ->relationship('modelo', 'nombre')
                    ->required()
                    ->reactive(),

                Forms\Components\Select::make('motor_id')
                    ->label('Motor')
                    ->relationship('motor', 'motor')
                    ->required()
                    ->reactive(),

                Forms\Components\TextInput::make('precio_basico')
                    ->label('Precio Básico')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $kitPrecio = optional($get('kit_id'))->precio ?? 0;
                        $cajaPrecio = optional($get('caja_id'))->precio ?? 0;
                        $modeloPrecio = optional($get('modelo_id'))->precio ?? 0;
                        $motorPrecio = optional($get('motor_id'))->precio ?? 0;

                        $precioTotal = ($state + $kitPrecio + $cajaPrecio + $modeloPrecio + $motorPrecio) * 1.21;
                        $set('precio_total', round($precioTotal, 2));
                    }),

                Forms\Components\TextInput::make('precio_total')
                    ->label('Precio Total (con IVA)')
                    ->numeric()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                Tables\Columns\TextColumn::make('kit.paquete')->label('Kit'),
                Tables\Columns\TextColumn::make('caja.tipo')->label('Caja'),
                Tables\Columns\TextColumn::make('modelo.nombre')->label('Modelo'),
                Tables\Columns\TextColumn::make('motor.motor')->label('Motor'),
                Tables\Columns\TextColumn::make('precio_basico')->label('Precio Básico')->money('eur', true),
                Tables\Columns\TextColumn::make('precio_total')->label('Precio Total')->money('eur', true),

               Tables\Columns\ImageColumn::make('imagenes_ruta')
    ->label('Imágenes')
    ->getStateUsing(fn ($record) => collect($record->imagenes_ruta)->map(fn ($ruta) => asset("storage/{$ruta}"))->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoches::route('/'),
            'create' => Pages\CreateCoche::route('/create'),
            'edit' => Pages\EditCoche::route('/{record}/edit'),
        ];
    }
}