<?php

namespace App\Filament\Resources\CocheResource\Pages;

use App\Filament\Resources\CocheResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoche extends EditRecord
{
    protected static string $resource = CocheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
