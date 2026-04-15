<?php

namespace App\Models;

use App\Models\Expenses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseSource extends Model
{
    /**
     * Get all of the expenses for the ExpenseSource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expenses::class);
    }
}
    