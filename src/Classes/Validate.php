<?php


namespace App\Classes;


use DateTime;

class Validate {
    public const SUPPORTED_CURRENCIES = ['USD', 'EUR', 'CHF', 'GBP'];


    public static function isSupportedCurrency(string $currency = '') : bool {
        if ($currency) {
            return in_array(strtoupper($currency), self::SUPPORTED_CURRENCIES);
        }
        return false;
    }

    public static function isDate(string $date = '') : bool {
        if ($date) {
            $dt = DateTime::createFromFormat('Y-m-d', $date);
            return $dt !== false && !array_sum($dt::getLastErrors());
        }
        return false;
    }
}