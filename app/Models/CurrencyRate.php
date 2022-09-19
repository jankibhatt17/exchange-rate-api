<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyRate extends Model
{
    use HasFactory;

    protected $table = 'currency_rates';

    protected $fillable = ['user_id', 'exchange_rate_id', 'date', 'currency', 'rate'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
