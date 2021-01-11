<?php

namespace App\Http\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Model\Currency;

class CurrencyController
{
    public function insertNewCurrencies()
    {
        $request = new Request();
        $response = new Response();
        $currentDate = new \DateTime($request->input('date'));
        if (empty(Currency::exist($request->input('date')))) {
            $xmlLink = simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $currentDate->format('d/m/Y'));
            $currency = new Currency();
            $currency->calendarDate = $currentDate->format('Y-m-d');
            $currency->lastPredictionDate = date('Y-m-d', strtotime($xmlLink['Date']));
            foreach ($xmlLink->Valute as $row) {
                $currency->valuteId = $row['ID'];
                $currency->currencyName = $row->Name;
                $currency->currencyValue = str_replace(',', '.', $row->Value);
                $currency->currencyNominal = (int)$row->Nominal;
                $currency->currencyCharCode = $row->CharCode;
                $currency->save();
            }
            $response->setStatusCode(200);
            $jsonOutput = [
                'message' => 'База данных обновлена на ' . $currentDate->format('Y-m-d')
            ];
            return $response->json($jsonOutput);
        } else {
            $response->setStatusCode(400);
            $jsonOutput = [
                'message' => 'Данные на ' . $currentDate->format('Y-m-d') . ' уже существуют в БД!'
            ];
            return $response->json($jsonOutput);
        }
    }

    public function getListOfCurrencies()
    {
        $request = new Request();
        $response = new Response();
        if (!empty(Currency::exist($request->input('date')))) {
            $currencies = Currency::getData($request->input('date'));
            $response->setStatusCode(200);
            return $response->json($currencies);
        } else {
            $data = [
                'message' => 'На этот день нет курсов!'
            ];
            $response->setStatusCode(404);
            return $response->json($data);
        }
    }

    public function getCharCodeAndNames()
    {
        $charCodeAndNames = [
            'AUD' => 'Австралийский доллар',
            'AZN' => 'Азербайджанский манат',
            'GBP' => 'Фунт стерлингов Соединенного королевства',
            'AMD' => 'Армянский драм',
            'BYN' => 'Белорусский рубль',
            'BGN' => 'Болгарский лев',
            'BRL' => 'Бразильский реал',
            'HUF' => 'Венгерский форинт',
            'HKD' => 'Гонконгский доллар ',
            'DKK' => 'Датская крона',
            'USD' => 'Доллар США',
            'EUR' => 'Евро',
            'INR' => 'Индийская рупия',
            'KZT' => 'Казахстанский тенге',
            'CAD' => 'Канадский доллар',
            'KGS' => 'Киргизский сом',
            'CNY' => 'Китайский юань',
            'MDL' => 'Молдавский лей',
            'NOK' => 'Норвежская крона',
            'PLN' => 'Польский злотый',
            'RON' => 'Румынский лей',
            'XDR' => 'CДР(специальные права заимствования)',
            'SGD' => 'Сингапурский доллар',
            'TJS' => 'Таджикский сомони',
            'TRY' => 'Турецкая лира',
            'TMT' => 'Новый туркменский манат',
            'UZS' => 'Узбекский сум ',
            'UAH' => 'Украинская гривна',
            'CZK' => 'Чешская крона',
            'SEK' => 'Шведская крона',
            'CHF' => 'Швейцарский франк',
            'ZAR' => 'Южноафриканский рэнд',
            'KRW' => 'Вон Республики Корея',
            'JPY' => 'Японская иена'
        ];
        View::render('home', [
            'charCodeAndNames' => $charCodeAndNames
        ]);
    }

    public function createChart()
    {
        $response = new Response();
        $request = new Request();
        if ($request->input('from_date') != '' && $request->input('to_date') != '' && $request->input('char_code') != '') {
            foreach (Currency::getDataForChart($request->input('from_date'), $request->input('to_date'), $request->input('char_code')) as $row) {
                $jsonOutput[] = [
                    'calendar_date' => $row['calendar_date'],
                    'currency_value' => $row['currency_value']
                ];
            }
            $response->setStatusCode(200);
            return $response->json($jsonOutput);
        } else {
            $jsonOutput = [
                'message' => 'Заполните све поля!'
            ];
            $response->setStatusCode(400);
            return $response->json($jsonOutput);
        }
    }
}