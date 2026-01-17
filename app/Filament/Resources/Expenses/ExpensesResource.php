<?php

namespace App\Filament\Resources\Expenses;

use App\Filament\Resources\Expenses\Pages\CreateExpenses;
use App\Filament\Resources\Expenses\Pages\EditExpenses;
use App\Filament\Resources\Expenses\Pages\ListExpenses;
use App\Filament\Resources\Expenses\Schemas\ExpensesForm;
use App\Filament\Resources\Expenses\Tables\ExpensesTable;
use App\Models\Expenses;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExpensesResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::CurrencyDollar;

    protected static ?string $recordTitleAttribute = 'Expenses';

    public static function form(Schema $schema): Schema
    {
        return ExpensesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpensesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExpenses::route('/'),
            'create' => CreateExpenses::route('/create'),
            'edit' => EditExpenses::route('/{record}/edit'),
        ];
    }
}
