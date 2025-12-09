<?php

if (! function_exists('format_currency')) {
    function format_currency($amount, $currency = 'BDT')
    {
        if ($amount === null) return null;

        // Format numeric value
        $formatted = number_format($amount, 0);

        return "{$formatted} {$currency}";
    }
}
