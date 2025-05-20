<?php

namespace App\Filament\Resources\CocheResource\Pages;

use App\Filament\Resources\CocheResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoches extends ListRecords
{
    protected static string $resource = CocheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
