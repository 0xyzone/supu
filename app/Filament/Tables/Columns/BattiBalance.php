<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;

class BattiBalance extends Column
{
    public $balance;

    public function balance():int
    {
        return 0;
    }
    protected string $view = 'filament.tables.columns.batti-balance';
}
