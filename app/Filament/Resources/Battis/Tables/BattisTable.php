<?php

namespace App\Filament\Resources\Battis\Tables;

use App\Filament\Tables\Columns\BattiBalance;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BattisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_rate'),
                TextColumn::make('unit_balance')
                    ->getStateUsing(function ($record) {
                        $prev = $record::where('id', '<', $record->id)->latest('id')->first();
                        return $prev ? ($record->amount - $prev->amount) : 0;
                    }),
                    TextColumn::make('to_pay')
                    ->getStateUsing(function ($record) {
                        $prev = $record::where('id', '<', $record->id)->latest('id')->first();
                        return $prev ? ($record->amount - $prev->amount) * $record->unit_rate : 0;
                    }),
                ImageColumn::make('image_path')
                    ->disk('public')
                    ->label('Image')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
