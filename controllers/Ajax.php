<?php

namespace controllers;

use models\Film;
use models\Seance;
use models\Ticket;
use resources\Config;
use resources\Helpers;

class Ajax extends Controller
{
    protected function render()
    {
    }

    public function action_getSeances()
    {
        $data = [];
        $extractedMeanings = Helpers::extractNecessary($_POST, ['date']);
        $seanceModel = new Seance();
        $dateSeance = $extractedMeanings['date'];
        $seances = $seanceModel->getSeancesForDay($dateSeance);
        $data['template'] = $this->template('available-films.php', ['seances' => $seances]);

        Helpers::setJsonHeaders();
        echo json_encode($data);
        die();
    }

    public function action_getFilm()
    {
        $data = [];
        $extractedMeanings = Helpers::extractNecessary($_POST, ['idSeance']);
        $filmModel = new Film();
        $idSeance = $extractedMeanings['idSeance'];
        $film = $filmModel->findFilmWithCountFreeSeats($idSeance);
        $data['template'] = $this->template('form-buy-ticket.php', ['film' => $film]);

        Helpers::setJsonHeaders();
        echo json_encode($data);
        die();
    }

    public function action_generateSeances()
    {
        $data = [];
        $filmModel = new Film();
        $films = $filmModel->findAll(Config::MYSQL_TABLE_FILM);
        $seanceModel = new Seance();
        $generatedSeances = $seanceModel->generateSeances($films);

        if ($seanceModel->multipleAddition(Config::MYSQL_TABLE_SEANCE, $generatedSeances)) {
            $seances = $seanceModel->findAll(Config::MYSQL_TABLE_SEANCE);
            $ticketModel = new Ticket();
            $generatedTickets = $ticketModel->generateTickets($seances);
            if ($ticketModel->multipleAddition(Config::MYSQL_TABLE_TICKET, $generatedTickets)) {
                $data = true;
            }
        }
        Helpers::setJsonHeaders();
        echo json_encode($data);
        die();
    }
}