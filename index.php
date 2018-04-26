<?php
include_once(__DIR__ . '/vendor/autoload.php');

use resources\Url;
use resources\Route;
use resources\Config;

try {
    $url = new Url($_GET[Config::QUERY]);
    $urlParams = $url->getParams();

    new Route($urlParams);
} catch (Exception $e) {
    echo $e;
}