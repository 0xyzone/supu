<?php

namespace App\Models;

use App\Models\Batti;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BattiPayment extends Model
{
    /**
     * Get the batti that owns the BattiPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function batti(): BelongsTo
    {
        return $this->belongsTo(Batti::class);
    }
}
