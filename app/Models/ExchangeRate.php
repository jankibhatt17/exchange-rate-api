<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    // We override the constructor to set if given the default 'from' 
    // and 'to' currencies values
    public function __construct(array $attributes = array(), $from = null, $to = null)
    {
        parent::__construct($attributes);

        if ($from && $to) {
            $this->start_date = $from;
            $this->end_date = $to;
        }
    }

    protected $table = 'exchange_rates';

    protected $fillable = ['base', 'start_date', 'end_date', 'created_at', 'updated_at'];

    public function currencyRates() {
        return $this->hasMany('App\Models\CurrencyRate', 'exchange_rate_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
