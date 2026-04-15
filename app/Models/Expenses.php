<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenses extends Model
{
    /**
     * Get the expense_source that owns the Expenses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense_source(): BelongsTo
    {
        return $this->belongsTo(ExpenseSource::class);
    }

    /**
     * Get the user that owns the Expenses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the done_by that owns the Expenses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doneBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'done_by', 'id');
    }
}
