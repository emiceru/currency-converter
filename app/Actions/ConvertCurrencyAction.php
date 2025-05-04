<?php

namespace App\Actions;

use App\Services\ExchangeRateService;

class ConvertCurrencyAction
{
    public static function run(array $params): array
    {
        $from = strtoupper($params['from'] ?? '');
        $to = strtoupper($params['to'] ?? '');
        $amount = (float) ($params['amount'] ?? 0);

        if (!$from || !$to || $amount <= 0) {
            throw new \InvalidArgumentException('Parámetros inválidos.');
        }

        $service = new ExchangeRateService();
        $rate = $service->getRate($from, $to);
        $converted = round($amount * $rate, 2);

        return [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
            'rate' => $rate,
            'converted_amount' => $converted,
        ];
    }
}
