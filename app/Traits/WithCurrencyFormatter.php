<?php

namespace App\Traits;

use NumberFormatter;

trait WithCurrencyFormatter
{
    //formatted_price
    public function formatCurrency($value):string{
        $formatter = new NumberFormatter('es_Ar',NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($value,'ARS');
    }
}
