<?php

namespace controllers;

class Index extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function action_index()
    {
        $this->title = 'Тестовое задание №2';
        $this->content = $this->template('index.php', []);
    }
}