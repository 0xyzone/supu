<?php

namespace App\Filament\Resources\Battis;

use App\Filament\Resources\Battis\Pages\CreateBatti;
use App\Filament\Resources\Battis\Pages\EditBatti;
use App\Filament\Resources\Battis\Pages\ListBattis;
use App\Filament\Resources\Battis\Schemas\BattiForm;
use App\Filament\Resources\Battis\Tables\BattisTable;
use App\Models\Batti;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BattiResource extends Resource
{
    protected static ?string $model = Batti::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLightBulb;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::LightBulb;

    protected static ?string $recordTitleAttribute = 'Batti';

    public static function form(Schema $schema): Schema
    {
        return BattiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BattisTable::configure($table);
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
            'index' => ListBattis::route('/'),
            'create' => CreateBatti::route('/create'),
            // 'edit' => EditBatti::route('/{record}/edit'),
        ];
    }
}
