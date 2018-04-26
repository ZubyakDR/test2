<?php

namespace models;

use resources\Config;
use resources\Helpers;

class Ticket extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $tickets array Купленные билеты
     */
    public function addTicketsToFilm(array $tickets)
    {
        $countTickets = $tickets['countTickets'];
        for ($i = 0; $i < $countTickets; $i++) {
            $this->save(Config::MYSQL_TABLE_TICKET, ['id_seance' => $tickets['idSeance']]);
        }
    }

    /**
     * @param $seances array Сеансы
     * @return array Сгенерированные билеты
     */
    public function generateTickets(array $seances): array
    {
        $tickets = [];
        $countSeances = count($seances);

        for ($i = 0; $i < $countSeances; $i++) {
            $countTicketPerSeance = Helpers::generateRandomInteger(Config::MIN_SEATS, Config::MAX_SEATS);
            for ($j = 0; $j < $countTicketPerSeance; $j++) {
                $tickets[$i][$j]['id_seance'] = $seances[$i]['id'];
            }
        }
        return $tickets;
    }
}