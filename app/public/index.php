<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers.php";

use Bramus\Router\Router;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Response;

use App\Exceptions\Authentication\InvalidCredentialsException;
use App\Exceptions\Jwt\InvalidJwtClaimException;
use App\Exceptions\Jwt\JwtDecodingException;
use App\Exceptions\MissingParameterException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Acquiring\PayController;
use App\Http\Controllers\Acquiring\PayControllerUat;
use App\Services\AuthenticationService;
use App\Concrete\JwtValidator;
use App\Http\Controllers\Acquiring\SeamlessController;
use App\Http\Controllers\Acquiring\SeamlessControllerUat;

use function DI\string;

$dotenv = Dotenv::createImmutable(__DIR__,"./");
$dotenv->load();

// if ($_ENV["DEVELOPMENT_MODE"] == "DEVELOPMENT") {
//     error_reporting(E_ALL);
// } else {
//     error_reporting(0);
// }

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions("config.php");
$container = $containerBuilder->build();

$router = new Router();

$router->before("POST", "/.*", function () {
    if (!checkVersionHeader($_SERVER)) {
        die();
    }
});

$router->match("GET", "/", function () use ($container) {

    $response = new Response(
        json_encode([
            "status" => 200,
            "status_text" => "Hey ho index ",
        ]),
        200,
        [
            "Content-Type" => "application/json",
            "Cache-Control" => "no-cache, private",
        ]
    );
    $response->send();
});

$router->set404(function () {
    $response = new Response(
        json_encode(["status" => 404, "status_text" => "route not defined"]),
        404,
        [
            "Content-Type" => "application/json",
            "Cache-Control" => "no-cache, private",
        ]
    );
    $response->setStatusCode(404, "Not Found");
    $response->send();
});
$router->run();
