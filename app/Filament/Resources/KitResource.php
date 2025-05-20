<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KitResource\Pages;
use App\Models\Kit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KitResource extends Resource
{
    protected static ?string $model = Kit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('paquete')
                    ->label('Paquete')
                    ->options([
                        'economico' => 'Económico',
                        'estandar' => 'Estándar',
                        'rs' => 'RS',
                    ])
                    ->required(),
                TextInput::make('precio')
                    ->label('Precio')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paquete')->label('Paquete')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('precio')->label('Precio')->money('usd', true)->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListKits::route('/'),
            'create' => Pages\CreateKit::route('/create'),
            'edit' => Pages\EditKit::route('/{record}/edit'),
        ];
    }
}
