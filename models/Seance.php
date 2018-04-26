<?php

namespace models;

use DateTime;
use resources\Config;
use resources\Helpers;

class Seance extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $dateSeance string Дата сеанса
     * @return array Сеансы на данную дату
     */
    public function getSeancesForDay(string $dateSeance): array
    {
        $dateForSeance = new DateTime($dateSeance);
        $formattedDateSeance = $dateForSeance->format(Config::FORMAT_DATE);
        $nowDate = new DateTime();
        $formattedNowDate = $nowDate->format(Config::FORMAT_DATE_FOR_DB);
        $maxSeats = Config::MAX_SEATS;
        return $this->db->select("SELECT title, durability,  {$maxSeats} - COUNT(t.id_seance) AS quantity_seats, s1.id, price, TIME(beginning) AS time 
                  FROM seance AS s1 
                  JOIN film AS f 
                  ON s1.id_film = f.id 
                  LEFT JOIN ticket AS t
                  ON t.id_seance = s1.id
                  WHERE DATE(beginning) = '{$formattedDateSeance}' 
                  AND beginning > '{$formattedNowDate}'
                  GROUP BY s1.id
                  ORDER BY time");
    }

    /**
     * @param $films array Все фильмы
     * @return array Сгенерированные сеансы
     */
    public function generateSeances(array $films): array
    {
        $seances = [];
        $countFilms = count($films);
        for ($i = 0; $i < $countFilms; $i++) {
            $beginningSeance = new DateTime();
            for ($j = 0; $j < Config::COUNT_GENERATE_DAY; $j++) {
                $seances[$i][$j]['id_film'] = $films[$i]['id'];
                $hundredForPrice = Helpers::generateRandomInteger(Config::MIN_HUNDRED_PRICE, Config::MAX_HUNDRED_PRICE);
                $seances[$i][$j]['price'] = $hundredForPrice . Config::END_MARKS_FOR_PRICE;
                $beginningSeance->modify(Config::PLUS_ONE_DAY);
                $hour = Helpers::generateRandomInteger(Config::START_SEANCE, Config::LAST_SEANCE);
                $beginningSeance->setTime($hour, '00', '00');
                $seances[$i][$j]['beginning'] = $beginningSeance->format(Config::FORMAT_DATE_FOR_DB);
            }
        }
        return $seances;
    }
}