<?php

namespace App\Filament\Resources\Battis\Schemas;

use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

class BattiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
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
                    ]),
                FileUpload::make('image_path')
                    ->image()
                    ->disk('public')
                    ->directory('batti_images'),
                Textarea::make('remarks')
                    ->columnSpanFull(),
                Section::make('Payments')
                    ->heading('')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('payments')
                            ->relationship('batti_payments')
                            ->columns(2)
                            ->schema([
                                Group::make()
                                    ->schema([
                                        DatePicker::make('date')
                                            ->label('Payment Date')
                                            ->native(false)
                                            ->columnSpan(1),
                                        TextInput::make('amount')
                                            ->label('Payment Amount')
                                            ->numeric()
                                            ->columnSpan(1),
                                    ]),
                                FileUpload::make('image_path')
                                    ->label('Payment Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('batti_payments'),
                                Textarea::make('remarks')
                                    ->label('Payment Remarks')
                                    ->columnSpanFull(),
                            ])
                    ]),
            ]);
    }
}
