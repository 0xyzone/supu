<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpensesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id()),
                Select::make('expense_source_id')
                    ->relationship('expense_source', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                    ])
                    ->required(),
                Select::make('done_by')
                    ->relationship('doneBy', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('date')
                    ->native(false)
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                FileUpload::make('image_path')
                    ->label('Receipt Image')
                    ->directory('receipts')
                    ->disk('public')
                    ->image(),
                Textarea::make('remarks')
                    ->columnSpanFull(),
            ]);
    }
}
