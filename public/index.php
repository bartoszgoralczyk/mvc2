<?php

// 1. Definicja domyślnej ścieżki dla dołączanych zasobów
define("APP_PATH", dirname(dirname(__FILE__))); 

// 2. Załadowanie głównej klasy zawierającej autoloader
require("../framework/core.php");
Framework\Core::initialize();

// 3. Załadowanie i inicjacja klasy Configuration
$configuration = new Framework\Configuration(array(
    "type" => "ini"
));
Framework\Registry::set("configuration", $configuration->initialize());

// 4. Załadowanie i inicjacja klasy Database - bez łączenia
$database = new Framework\Database();
Framework\Registry::set("database", $database->initialize());

// 5. Załadowanie i inicjacja klasy Cache - bez łączenia
$cache = new Framework\Cache();
Framework\Registry::set("cache", $cache->initialize());

// 6. Załadowanie i inicjacja klasy Session
$session = new Framework\Session();
Framework\Registry::set("session", $session->initialize());

// 7. Załadowanie klasy Router oraz dostarczenie adresu URL i rozszerzenia
$router = new Framework\Router(array(
    "url" => isset($_GET["url"]) ? $_GET["url"] : "home/index",
    "extension" => isset($_GET["url"]) ? $_GET["url"] : "html"
));
Framework\Registry::set("router", $router);

// 8. Przekazanie bieżącego żądania
$router->dispatch();

// 9. Likwidacja globalnych zmiennych
unset($configuration);
unset($database);
unset($cache);
unset($session);
unset($router);
