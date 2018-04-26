<?php

namespace resources;

class Config{
    const DATABASES = [
        'type' => 'mysql',
        'server' => 'localhost',
        'user' => 'root',
        'password' => 'Qwerty1!',
        'database' => 'test3'
    ];
    const SCRIPTS = [
        'jquery',
        'bootstrap.min',
        'bootstrap-datepicker.min',
        'script'
    ];
    const STYLES = [
        'bootstrap.min',
        'bootstrap-datepicker.min',
        'style'
    ];
    const BASE_THEME = 'main.php';
    const BASE_URL = '/';
    const CSS = '/media/css/';
    const JS = '/media/js/';
    const VIEW = 'views/';
    const MAX_SEATS = 30;
    const MIN_SEATS = 0;
    const MIN_HUNDRED_PRICE = 2;
    const MAX_HUNDRED_PRICE = 8;
    const END_MARKS_FOR_PRICE = '00';
    const START_SEANCE = 9;
    const LAST_SEANCE = 23;
    const COUNT_GENERATE_DAY = 30;
    const MYSQL_TABLE_FILM = 'film';
    const MYSQL_TABLE_SEANCE = 'seance';
    const MYSQL_TABLE_TICKET = 'ticket';
    const PLUS_ONE_DAY = '+1 day';
    const PREFIX_ACTION = 'action_';
    const QUERY = 'query_string';
    const JSON_HEADER = 'Content-Type: application/json';
    const FORMAT_DATE_FOR_DB = 'Y-m-d H:i:s';
    const FORMAT_DATE = 'Y-m-d';
}