<?php

/** @var Router $router */

use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Router;

$router->get('/key', function () {
    return Str::random(32);
});

$router->get('/', function () use ($router) {
    return view("home");
});

$router->get("filter", "CountriesFilterController@filter");
