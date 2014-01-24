<?php

// definicje tras

$routes = array(
    array(
        "pattern" => "register",
        "controller" => "users",
        "action" => "register"
    ),
    array(
        "pattern" => "login",
        "controller" => "users",
        "action" => "login"
    ),
    array(
        "pattern" => "logout",
        "controller" => "users",
        "action" => "logout"
    ),
    array(
        "pattern" => "search",
        "controller" => "users",
        "action" => "search"
    ),
    array(
        "pattern" => "profile",
        "controller" => "users",
        "action" => "profile"
    ),
    array(
        "pattern" => "settings",
        "controller" => "users",
        "action" => "settings"
    ),
    array(
        "pattern" => "unfriend/:id",
        "controller" => "users",
        "action" => "friend"
    ),
    array(
        "pattern" => "friend/:id",
        "controller" => "users",
        "action" => "friend"
    )
);

// dodanie zdefiniowanych tras

foreach ($routes as $route)
{
    $router->addRoute(new Framework\Router\Route\Simple($route));
}

// usunięcie globalnych zmiennych

unset($routes);
