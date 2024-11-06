<?php

use App\Concrete\DbalConnector;
use App\Concrete\JwtValidator;
use App\Contracts\IDatabaseConnection;
use App\Contracts\IJwtValidator;
use App\Repositories\AppRepository;


return [
    IDatabaseConnection::class => \DI\factory(function () {
        $host = $_ENV["DB_HOST"];
        $username = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];
        $database = $_ENV["DB_NAME"];

        return new DbalConnector($host, $username, $password, $database);
    }),

    IJwtValidator::class => \DI\factory(function () {
        $key = $_ENV["JWT_SECRET"];
        return new JwtValidator($key);
    }),

    App\Services\AuthenticationService::class => \DI\autowire()->constructor(
        \DI\get(AppRepository::class),
        \DI\env("JWT_SECRET")
    ),
];
