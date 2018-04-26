<?php

namespace resources;

class Helpers
{
    /**
     * @param $minParam int минимальное значение
     * @param $maxParam int максимальное значение
     * @return int рандомное число
     */
    public static function generateRandomInteger(int $minParam, int $maxParam) : int
    {
        return rand($minParam, $maxParam);
    }

    /**
     * @param $url string адрес перенаправление
     */
    public static function redirect(string $url)
    {
        header("location: $url");
        exit();
    }

    /**
     * @param $meanings array полученные данные от пользователя
     * @param $needMeanings array поля, которые нужны
     * @return array сформированный массив с нужными данными
     */
    public static function extractNecessary(array $meanings, array $needMeanings) : array
    {
        $extractedMeanings = [];

        foreach ($meanings as $key => $meaning) {
            if (in_array($key, $needMeanings)) {
                $extractedMeanings[$key] = $meaning;
            }
        }

        foreach ($needMeanings as $needMeaning) {
            if (!isset($extractedMeanings[$needMeaning])) {
                $extractedMeanings[$needMeaning] = '';
            }
        }
        return $extractedMeanings;
    }

    public static function setJsonHeaders()
    {
        header(Config::JSON_HEADER);
    }
}