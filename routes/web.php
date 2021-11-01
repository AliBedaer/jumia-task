<?php

/** @var Router $router */

use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Router;

/**
 * @desc this will return a key for teh .env APP_KEY
 */
$router->get('/key', function () {
    return Str::random(32);
});

$router->get('/', function () use ($router) {
    return view("home");
});

// the filter api
$router->get("filter", "CountriesFilterController@filter");
