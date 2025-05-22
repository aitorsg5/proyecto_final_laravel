<?php

namespace App\Filament\Resources\CestaResource\Pages;

use App\Filament\Resources\CestaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCesta extends EditRecord
{
    protected static string $resource = CestaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
