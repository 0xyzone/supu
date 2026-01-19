<?php

namespace App\Filament\Resources\Battis\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use App\Filament\Tables\Columns\BattiBalance;

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
                TextColumn::make('total_to_pay')
                    ->getStateUsing(function ($record) {
                        $prev = $record::where('id', '<', $record->id)->latest('id')->first();
                        return $prev ? ($record->amount - $prev->amount) * $record->unit_rate : 0;
                    }),
                TextColumn::make('balance')
                    ->getStateUsing(function ($record) {
                        $prev = $record::where('id', '<', $record->id)->latest('id')->first();
                        $payableAmount = $prev ? ($record->amount - $prev->amount) * $record->unit_rate : 0;
                        if ($record->batti_payments()->count() > 0) {
                            $totalPaid = $record->batti_payments()->sum('amount');
                            $payableAmount -= $totalPaid;
                        }
                        return number_format($payableAmount, 2);
                    }),
                ImageColumn::make('image_path')
                    ->disk('public')
                    ->label('Image')
                    ->simpleLightbox(),
                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $prev = $record::where('id', '<', $record->id)->latest('id')->first();
                        $payableAmount = $prev ? ($record->amount - $prev->amount) * $record->unit_rate : 0;
                        $totalPaid = $record->batti_payments()->sum('amount');
                        $toPay = $payableAmount;
                        if ($totalPaid >= $toPay) {
                            return 'Paid';
                        } elseif ($totalPaid > 0) {
                            return 'Partial';
                        } else {
                            return 'Unpaid';
                        }
                    })
                    ->colors([
                        'success' => 'Paid',
                        'warning' => 'Partial',
                        'danger' => 'Unpaid',
                    ])
                    ->sortable(),
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
                Action::make('payments')
                    ->label('Manage Payments')
                    ->icon('heroicon-o-currency-dollar')
                    ->mountUsing(function ($form, $record) {
                        // This fills the repeater with the existing relationship data
                        $form->fill([
                            'payments' => $record->batti_payments->toArray(),
                        ]);
                    })
                    ->form([
                        Placeholder::make('payable_amount')
                            ->label('Payable Amount')
                            ->disabled()
                            ->content(fn ($record) => function () use ($record) {
                                $prev = $record::where('id', '<', $record->id)->latest('id')->first();
                                $payableAmount = $prev ? ($record->amount - $prev->amount) * $record->unit_rate : 0;
                                if($record->batti_payments()->count() > 0){
                                    $totalPaid = $record->batti_payments()->sum('amount');
                                    $payableAmount -= $totalPaid;
                                }
                                return number_format($payableAmount, 2);
                            }),
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
                            ]),
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
