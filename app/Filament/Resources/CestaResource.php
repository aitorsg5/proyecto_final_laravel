<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CestaResource\Pages;
use App\Models\Cesta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CestaResource extends Resource
{
    protected static ?string $model = Cesta::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->relationship('user', 'name')
                ->required(),

            Forms\Components\Select::make('coche_id')
                ->label('Coche')
                ->relationship('coche', 'nombre')
                ->required(),

            Forms\Components\TextInput::make('precio_total')
                ->label('Precio total (€)')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Usuario'),
                Tables\Columns\TextColumn::make('coche.nombre')->label('Coche'),
                Tables\Columns\TextColumn::make('precio_total')->label('Precio total'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCestas::route('/'),
            'create' => Pages\CreateCesta::route('/create'),
            'edit' => Pages\EditCesta::route('/{record}/edit'),
        ];
    }
}