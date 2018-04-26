<?php

namespace models;

use resources\Config;

class Film extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $idSeance int ид сеанса
     * @return array
     */
    public function findFilmWithCountFreeSeats(int $idSeance): array
    {
        $maxSeats = Config::MAX_SEATS;
        $film = $this->db->select("SELECT title, {$maxSeats} - COUNT(t.id_seance) AS quantity_seats, s1.id, price, DATE_FORMAT(beginning, '%e-%m-%Y %k:%i:%s') AS beginning
              FROM film AS f 
              JOIN seance AS s1 
              ON s1.id_film = f.id 
              LEFT JOIN ticket AS t
              ON t.id_seance = s1.id
              WHERE s1.id = {$idSeance}
              GROUP BY t.id_seance");
        return $film[0];
    }
}