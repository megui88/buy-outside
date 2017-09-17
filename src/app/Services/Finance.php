<?php

namespace App\Services;


use App\Exceptions\FinanceException;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Finance
{
    const DOLLAR_CURRENCY = 'USD';
    const FINANCE_URI = 'https://finance.google.com/finance/converter';
    const CACHE_TTL = 5;   //minutes

    private $countries = [
        self::DOLLAR_CURRENCY => ['currency' => 'USD', 'country' => 'E.E.U.U.'],
        'ARG' => ['currency' => 'ARS', 'country' => 'Argentina'],
        'CHI' => ['currency' => 'CLP', 'country' => 'Chile'],
        'BOL' => ['currency' => 'BOB', 'country' => 'Bolivia'],
        'BRA' => ['currency' => 'BRL', 'country' => 'Brasil'],
        'COL' => ['currency' => 'COP', 'country' => 'Colombia'],
        'CRI' => ['currency' => 'CRC', 'country' => 'Costa Rica'],
        'DOM' => ['currency' => 'DOP', 'country' => 'Dominicana'],
        'ECU' => ['currency' => 'USD', 'country' => 'Ecuador'],
        'GUA' => ['currency' => 'GTQ', 'country' => 'Guatemala'],
        'HON' => ['currency' => 'HNL', 'country' => 'Honduras'],
        'MEX' => ['currency' => 'MXN', 'country' => 'Mexico'],
        'NIC' => ['currency' => 'NIO', 'country' => 'Nicaragua'],
        'PAN' => ['currency' => 'PAB', 'country' => 'Panamanian'],
        'PAR' => ['currency' => 'PYG', 'country' => 'Paraguay'],
        'PER' => ['currency' => 'PEN', 'country' => 'Peru'],
        'SAL' => ['currency' => 'SVC', 'country' => 'Salvador'],
        'URU' => ['currency' => 'UYU', 'country' => 'Uruguay'],
        'VEN' => ['currency' => 'VEF', 'country' => 'Venezuela'],
    ];
    /** @var  Client */
    private $client;

    public function getConverter($countryCode)
    {
        if (!key_exists($countryCode, $this->countries)) {
            throw new FinanceException('Currency is not allowed');
        }

        if (false && !empty($this->conversion($countryCode))) {
            return $this->conversion($countryCode);
        }

        return $this->convert(self::DOLLAR_CURRENCY, $countryCode);
    }

    public function getCountry($countryCode)
    {
        return $this->countries[$countryCode]['country'];
    }

    public function getCurrency($countryCode)
    {
        return $this->countries[$countryCode]['currency'];
    }

    public function renderSelect($id, $current)
    {
        $select = '<select name="' . $id . '" id="' . $id . '">' . PHP_EOL;
        foreach ($this->countries as $code => $data) {
            $selected = $code == $current ? 'selected' : '';

            $select .= '<option value="' . $code . '" ' . $selected . '>' . $data['country'] . '</option>' . PHP_EOL;
        }

        return $select . '</select>';
    }

    private function conversion($currency)
    {
        return Cache::get(static::generateKey($currency));
    }

    static private function generateKey($currency)
    {
        return self::DOLLAR_CURRENCY . ':' . $currency;
    }

    private function convert($fromCountry, $toCountry)
    {
        $fromCurrency = $this->countries[$fromCountry]['currency'];
        $toCurrency = $this->countries[$toCountry]['currency'];
        $res = $this->getClient()->request(
            'GET',
            self::FINANCE_URI,
            [
                'query' => [
                    'a' => 1,
                    'from' => $fromCurrency,
                    'to' => $toCurrency,
                ]
            ]
        );

        $content = $res->getBody()->getContents();
        $crawler = new Crawler($content);
        $span = $crawler->filter('span.bld');
        $value = (float)$span->text();

        Cache::put(static::generateKey($toCurrency), $value, self::CACHE_TTL);
        return $value;
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        if ($this->client) {
            return $this->client;
        }
        return $this->client = new Client(['cookies' => true]);
    }

}