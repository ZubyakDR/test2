<?php

namespace models;

class Administrator extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array ошибки в расписании
     */
    public function getErrorsInSchedule(): array
    {
        return $this->db->select("SELECT *
            FROM
            (SELECT title AS filmOne, beginning AS beginningFilmOne, durability AS durabilityFilmOne
            FROM film f
            LEFT JOIN seance s1
            ON f.id = s1.id_film
            ) AS f1,
            (SELECT title AS filmTwo, beginning AS beginningFilmTwo, durability AS durabilityFilmTwo
            FROM film f
            LEFT JOIN seance s1
            ON f.id = s1.id_film
            ) AS f2
            WHERE beginningFilmTwo < (beginningFilmOne + INTERVAL durabilityFilmOne MINUTE)
            AND beginningFilmTwo > beginningFilmOne
            ORDER BY beginningFilmTwo ASC");
    }

    /**
     * @return array перерыв >= 30 минут
     */
    public function getBreaksGreaterThirtyMinutes(): array
    {
        return $this->db->select("SELECT
            f.title AS film,
            s1.beginning AS beginningFilmOne,
            f.durability AS durability,
            MIN(s2.beginning) AS beginningFilmTwo,
            TIMEDIFF( MIN(s2.beginning), DATE_ADD(s1.beginning, INTERVAL f.durability MINUTE) ) AS durationBreak
            FROM film f
            JOIN seance s1 ON s1.id_film = f.id
            JOIN seance s2 ON s1.beginning < s2.beginning
            GROUP BY s1.beginning
            HAVING durationBreak >= '00:30:00'
            ORDER BY durationBreak DESC");
    }

    /**
     * @return array статистика по фильмам
     */
    public function getStatisticsOnFilm(): array
    {
        $countFilms = $this->getCountFilms();
        return $this->db->select("(SELECT
            f.title AS titleFilm, 
            COUNT(*) AS totalVisitors,
            ROUND(COUNT(*) / COUNT(DISTINCT t.id_seance), 0) AS averageVisitors,
            SUM(s1.price) AS totalAmount
            FROM film f
            JOIN seance s1 ON f.id = s1.id_film
            JOIN ticket t ON s1.id = t.id_seance
            GROUP BY f.title
            ORDER BY totalAmount DESC
            LIMIT {$countFilms})
            UNION
            (SELECT 
            'Итого', 
            COUNT(*), 
            ROUND(COUNT(t.id_seance) / COUNT(DISTINCT t.id_seance),0), 
            SUM(s1.price)
            FROM seance s1
            JOIN ticket t ON s1.id = t.id_seance)");
    }

    /**
     * @return int колличество фильмов
     */
    private function getCountFilms(): int
    {
        $countFilms = $this->db->select("SELECT COUNT(*) AS countFilms FROM film");
        return $countFilms[0]['countFilms'];
    }

    /**
     * @return array статистика по часам
     */
    public function getCountVisitorsAndProceeds(): array
    {
        return $this->db->select(
            "(SELECT 'С 9 до 15' AS timeInterval, SUM(price) AS totalPrice, COUNT(*) AS totalVisitors
            FROM seance s1
            JOIN ticket t ON s1.id = t.id_seance
            WHERE (HOUR(beginning) >= 9 AND HOUR(beginning) < 15)
            GROUP BY timeInterval)
            UNION
            (SELECT 'С 15 до 18' AS timeInterval, SUM(price) AS totalPrice, COUNT(*) AS totalVisitors 
            FROM seance s1
            JOIN ticket t ON s1.id = t.id_seance
            WHERE (HOUR(beginning) >= 15 AND HOUR(beginning) < 18)
            GROUP BY timeInterval)
            UNION
            (SELECT 'С 18 до 21' AS timeInterval, SUM(price) AS totalPrice, COUNT(*) AS totalVisitors
            FROM seance s1
            JOIN ticket t ON s1.id = t.id_seance
            WHERE (HOUR(beginning) >= 18 AND HOUR(beginning) < 21)
            GROUP BY timeInterval)
            UNION
            (SELECT 'С 18 до 21' AS timeInterval, SUM(price) AS totalPrice, COUNT(*) AS totalVisitors
            FROM seance s1
            JOIN ticket t ON s1.id = t.id_seance
            WHERE (HOUR(beginning) >= 21 AND HOUR(beginning) < 24)
            GROUP BY timeInterval)");
    }
}