<?php

namespace App\Model;

use App\Core\Application;
use App\Core\Model;

class Currency extends Model
{
    public string $valuteId;

    public string $currencyName;

    public float $currencyValue;

    public int $currencyNominal;

    public string $currencyCharCode;

    public string $calendarDate;

    public string $lastPredictionDate;

    public function save(): void
    {
        $stm = Application::$app->dataBase->pdo->prepare("INSERT INTO currency (calendar_date, last_prediction_date, valute_id, name, value, valute_nominal, char_code) 
                VALUES (STR_TO_DATE(?, '%Y-%m-%d'), STR_TO_DATE(?, '%Y-%m-%d'), ?, ?, ?, ?, ?)");
        $stm->execute([
            $this->calendarDate,
            $this->lastPredictionDate,
            $this->valuteId,
            $this->currencyName,
            $this->currencyValue,
            $this->currencyNominal,
            $this->currencyCharCode
        ]);
    }

    public static function getDataForChart(string $fromDate, string $toDate, string $charCode): array
    {
        $stm = Application::$app->dataBase->pdo->prepare("SELECT calendar_date, (value / valute_nominal) AS currency_value FROM currency 
                WHERE calendar_date BETWEEN STR_TO_DATE(?, '%Y-%m-%d') AND STR_TO_DATE(?, '%Y-%m-%d') 
                AND char_code = ? ORDER BY calendar_date");
        $stm->execute([
            $fromDate,
            $toDate,
            $charCode
        ]);
        return $stm->fetchAll();
    }

    public static function getData(string $calendarDate): array
    {
        $stm = Application::$app->dataBase->pdo->prepare("SELECT * FROM currency WHERE calendar_date = STR_TO_DATE(?, '%Y-%m-%d')");
        $stm->execute([
            $calendarDate
        ]);
        return $stm->fetchAll();
    }

    public static function exist(string $calendarDate): int
    {
        $stm = Application::$app->dataBase->pdo->prepare("SELECT COUNT(*) FROM currency WHERE calendar_date = STR_TO_DATE(?, '%Y-%m-%d')");
        $stm->execute([
            $calendarDate
        ]);
        return $stm->fetchColumn();
    }
}