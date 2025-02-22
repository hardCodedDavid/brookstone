<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deposit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
