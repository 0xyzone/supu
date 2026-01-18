<?php

namespace App\Models;

use App\Models\BattiPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batti extends Model
{
    /**
     * Get all of the payments for the Batti
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function batti_payments(): HasMany
    {
        return $this->hasMany(BattiPayment::class);
    }
}
