<?php

if (! function_exists('format_currency')) {
    function format_currency($amount, $currency = 'BDT')
    {
        if ($amount === null) return null;

        $formatted = number_format($amount, 2, '.', ',');
        $formatted = rtrim(rtrim($formatted, '0'), '.');

        return "{$formatted} {$currency}";
    }
}
