<?php

namespace App\Filament\Resources\CestaResource\Pages;

use App\Filament\Resources\CestaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCestas extends ListRecords
{
    protected static string $resource = CestaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
