<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotorResource\Pages;
use App\Models\Motor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MotorResource extends Resource
{
    protected static ?string $model = Motor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('motor')
                ->label('Motor')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('combustible')
                ->label('Combustible')
                ->options([
                    'gasolina' => 'Gasolina',
                    'diesel' => 'Diésel',
                    'electrico' => 'Eléctrico',
                ])
                ->required(),
            Forms\Components\TextInput::make('precio')
                ->label('Precio')
                ->numeric()
                ->required(),
            Forms\Components\Toggle::make('turbo')
                ->label('Turbo'),
            Forms\Components\TextInput::make('cc')
                ->label('Cilindrada (cc)')
                ->numeric()
                ->required(),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('motor')->label('Motor')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('combustible')->label('Combustible')->sortable(),
            Tables\Columns\TextColumn::make('precio')->label('Precio')->sortable(),
            Tables\Columns\BooleanColumn::make('turbo')->label('Turbo'),
            Tables\Columns\TextColumn::make('cc')->label('Cilindrada (cc)')->sortable(),
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
        'index' => Pages\ListMotors::route('/'),
        'create' => Pages\CreateMotor::route('/create'),
        'edit' => Pages\EditMotor::route('/{record}/edit'),
    ];
}
}
