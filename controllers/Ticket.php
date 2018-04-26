<?php

namespace controllers;

use models\Ticket as TicketModel;
use resources\Helpers;

class Ticket extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function action_index()
    {
        $this->title = 'Покупка билетов';

        if ($this->isPost()) {
            $ticket = new TicketModel();
            $extractedMeanings = Helpers::extractNecessary($_POST, ['countTickets', 'idSeance']);
            $ticket->addTicketsToFilm($extractedMeanings);
        }

        $this->content = $this->template('ticket.php', []);
    }
}