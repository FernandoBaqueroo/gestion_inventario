<?php

require_once __DIR__ . '/../core/ApiService.php';

/**
 * Servicio para obtener tipos de cambio de moneda
 * Usa la API gratuita de exchangerate-api.com
 */
class ExchangeRateService extends ApiService
{
    public function __construct()
    {
        parent::__construct();

        // API gratuita de exchangerate-api.com
        // No requiere API key para uso básico
        $this->baseUrl = 'https://api.exchangerate-api.com/v4/';

        // Cache por 6 horas (las tasas no cambian tan rápido)
        $this->cacheDuration = 21600;
    }

    /**
     * Obtener tasa de cambio entre dos monedas
     * 
     * @param string $from Moneda origen (ej: 'USD')
     * @param string $to Moneda destino (ej: 'EUR')
     * @return float|null Tasa de cambio o null si hay error
     */
    public function getRate($from = 'USD', $to = 'EUR')
    {
        $data = $this->getLatestRates($from);

        if ($data === null || !isset($data['rates'][$to])) {
            return null;
        }

        return $data['rates'][$to];
    }

    /**
     * Obtener todas las tasas de cambio para una moneda base
     * 
     * @param string $base Moneda base (ej: 'USD')
     * @return array|null Datos de tasas o null si hay error
     */
    public function getLatestRates($base = 'USD')
    {
        return $this->get("latest/{$base}");
    }

    /**
     * Obtener múltiples tasas de cambio
     * 
     * @param string $base Moneda base
     * @param array $currencies Array de códigos de moneda
     * @return array Array asociativo con tasas
     */
    public function getMultipleRates($base = 'USD', $currencies = ['EUR', 'GBP', 'JPY'])
    {
        $data = $this->getLatestRates($base);

        if ($data === null || !isset($data['rates'])) {
            return [];
        }

        $result = [];
        foreach ($currencies as $currency) {
            if (isset($data['rates'][$currency])) {
                $result[$currency] = $data['rates'][$currency];
            }
        }

        return $result;
    }

    /**
     * Convertir cantidad de una moneda a otra
     * 
     * @param float $amount Cantidad a convertir
     * @param string $from Moneda origen
     * @param string $to Moneda destino
     * @return float|null Cantidad convertida o null si hay error
     */
    public function convert($amount, $from = 'USD', $to = 'EUR')
    {
        $rate = $this->getRate($from, $to);

        if ($rate === null) {
            return null;
        }

        return round($amount * $rate, 2);
    }

    /**
     * Obtener información de monedas soportadas
     * 
     * @return array Lista de monedas comunes
     */
    public function getSupportedCurrencies()
    {
        return [
            'USD' => ['name' => 'Dólar Estadounidense', 'symbol' => '$'],
            'EUR' => ['name' => 'Euro', 'symbol' => '€'],
            'GBP' => ['name' => 'Libra Esterlina', 'symbol' => '£'],
            'JPY' => ['name' => 'Yen Japonés', 'symbol' => '¥'],
            'CAD' => ['name' => 'Dólar Canadiense', 'symbol' => 'C$'],
            'AUD' => ['name' => 'Dólar Australiano', 'symbol' => 'A$'],
            'CHF' => ['name' => 'Franco Suizo', 'symbol' => 'CHF'],
            'CNY' => ['name' => 'Yuan Chino', 'symbol' => '¥'],
            'MXN' => ['name' => 'Peso Mexicano', 'symbol' => '$'],
            'BRL' => ['name' => 'Real Brasileño', 'symbol' => 'R$']
        ];
    }
}
