<?php

namespace controllers;

use models\Film;
use resources\Config;
use resources\Helpers;

class Generator extends Base
{

    public function __construct()
    {
        parent::__construct();
    }

    public function action_index()
    {
        $this->title = 'Генератор';
        $filmModel = new Film();
        $films = $filmModel->findAll(Config::MYSQL_TABLE_FILM);

        if ($this->isPost()) {
            $extractedMeanings = Helpers::extractNecessary($_POST, ['title', 'durability']);
            if ($filmModel->save(Config::MYSQL_TABLE_FILM, $extractedMeanings)) {
                Helpers::redirect('/generator');
            }
        }
        $this->content = $this->template('generator.php', ['films' => $films]);
    }
}