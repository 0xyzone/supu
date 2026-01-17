<?php

namespace App\Filament\Resources\Battis\Pages;

use App\Filament\Resources\Battis\BattiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBatti extends EditRecord
{
    protected static string $resource = BattiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
