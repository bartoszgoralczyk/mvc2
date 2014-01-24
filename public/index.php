<?php
$st = microtime(true);
// stałe

define("DEBUG", TRUE);
define("APP_PATH", dirname(__DIR__));

try
{
    // rdzeń

    require("../framework/core.php");
    Framework\Core::initialize();

    // konfiguracja

    $configuration = new Framework\Configuration(array(
        "type" => "ini"
    ));
    Framework\Registry::set("configuration", $configuration->initialize());

    // baza danych

    $database = new Framework\Database();
    Framework\Registry::set("database", $database->initialize());

   // bufor

    $cache = new Framework\Cache();
    Framework\Registry::set("cache", $cache->initialize());

    // sesja

    $session = new Framework\Session();
    Framework\Registry::set("session", $session->initialize());

    // router

    $router = new Framework\Router(array(
        "url" => isset($_GET["url"]) ? $_GET["url"] : "home/index",
        "extension" => isset($_GET["url"]) ? $_GET["url"] : "html"
    ));
    Framework\Registry::set("router", $router);

    // Dołączenie własnych tras

    include("routes.php");

    // dyspozycja + czyszczenie

    $router->dispatch();

    // usunięcie globalnych zmiennych

    unset($configuration);
    unset($database);
    unset($cache);
    unset($session);
    unset($router);
    echo "time: " . round(microtime(true)-$st,2);
}
catch (Exception $e)
{
    // lista wyjątków

    $exceptions = array(
        "500" => array(
            "Framework\Cache\Exception",
            "Framework\Cache\Exception\Argument",
            "Framework\Cache\Exception\Implementation",
            "Framework\Cache\Exception\Service",

            "Framework\Configuration\Exception",
            "Framework\Configuration\Exception\Argument",
            "Framework\Configuration\Exception\Implementation",
            "Framework\Configuration\Exception\Syntax",

            "Framework\Controller\Exception",
            "Framework\Controller\Exception\Argument",
            "Framework\Controller\Exception\Implementation",

            "Framework\Core\Exception",
            "Framework\Core\Exception\Argument",
            "Framework\Core\Exception\Implementation",
            "Framework\Core\Exception\Property",
            "Framework\Core\Exception\ReadOnly",
            "Framework\Core\Exception\WriteOnly",

            "Framework\Database\Exception",
            "Framework\Database\Exception\Argument",
            "Framework\Database\Exception\Implementation",
            "Framework\Database\Exception\Service",
            "Framework\Database\Exception\Sql",

            "Framework\Model\Exception",
            "Framework\Model\Exception\Argument",
            "Framework\Model\Exception\Connector",
            "Framework\Model\Exception\Implementation",
            "Framework\Model\Exception\Primary",
            "Framework\Model\Exception\Type",
            "Framework\Model\Exception\Validation",

            "Framework\Request\Exception",
            "Framework\Request\Exception\Argument",
            "Framework\Request\Exception\Implementation",
            "Framework\Request\Exception\Response",

            "Framework\Router\Exception",
            "Framework\Router\Exception\Argument",
            "Framework\Router\Exception\Implementation",

            "Framework\Session\Exception",
            "Framework\Session\Exception\Argument",
            "Framework\Session\Exception\Implementation",

            "Framework\Template\Exception",
            "Framework\Template\Exception\Argument",
            "Framework\Template\Exception\Implementation",
            "Framework\Template\Exception\Parser",

            "Framework\View\Exception",
            "Framework\View\Exception\Argument",
            "Framework\View\Exception\Data",
            "Framework\View\Exception\Implementation",
            "Framework\View\Exception\Renderer",
            "Framework\View\Exception\Syntax"
        ),
        "404" => array(
            "Framework\Router\Exception\Action",
            "Framework\Router\Exception\Controller"
        )
    );

    $exception = get_class($e);

    // próba znalezienia odpowiedniego szablonu i renderowanie

    foreach ($exceptions as $template => $classes)
    {
        foreach ($classes as $class)
        {
            if ($class == $exception)
            {
                header("Content-type: text/html");
                include(APP_PATH."/application/views/errors/{$template}.php");
                exit;
            }
        }
    }

    // awaryjny szablon renderowania

    header("Content-type: text/html");
    echo "Wystąpił błąd.";
    exit;
}