<?php

namespace App\Filament\Resources\Battis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BattiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                ->native(false)
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('unit_rate')
                    ->required()
                    ->numeric()
                    ->default(15),
                FileUpload::make('image_path')
                    ->image()
                    ->disk('public')
                    ->directory('batti_images'),
                Textarea::make('remarks')
                    ->columnSpanFull(),
            ]);
    }
}
