<?php

namespace App\Filament\Resources\Battis\Pages;

use App\Filament\Resources\Battis\BattiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBattis extends ListRecords
{
    protected static string $resource = BattiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
