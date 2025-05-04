<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    protected string $baseUrl = 'https://open.er-api.com/v6/latest/';

    public function getRate(string $from, string $to): float
    {
        $response = Http::withoutVerifying()->get($this->baseUrl . strtoupper($from));


        if ($response->failed()) {
            throw new \Exception("Error al obtener los tipos de cambio.");
        }

        $data = $response->json();

        if (!isset($data['rates'][strtoupper($to)])) {
            throw new \Exception("Moneda destino '$to' no encontrada.");
        }

        return (float) $data['rates'][strtoupper($to)];
    }
}
