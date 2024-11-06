<?php

use Symfony\Component\HttpFoundation\Response;
use App\Concrete\JwtValidator;

/**
 * Checks if the X-Header header was passed.
 *
 * @param array $x_header The instance of $_SERVER
 * @return bool
 */
function checkVersionHeader(array $x_header): bool
{
    if (
        isset($x_header["HTTP_X_VERSION"]) &&
        trim($x_header["HTTP_X_VERSION"]) == "v1"
    ) {
        return true;
    }

    $response = new Response(
        json_encode([
            "status" => "428",
            "status_text" => "Invalid X-Version value.",
        ]),
        428,
        [
            "Content-Type" => "application/json",
            "Cache-Control" => "no-cache, private",
        ]
    );

    $response->setStatusCode(428, "Precondition Required");
    $response->send();

    return false;
}

/**

 * Checks if the AUTHORIZATION header was passed.
 *
 * @param array $x_header The instance of $_SERVER
 * @return string|null
 */
function checkBearer(array $x_header): ?string
{
    if (
        isset($x_header["HTTP_AUTHORIZATION"])
    ) {
        $token = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
        $token = $token[1];
        return $token;
    }

    $response = new Response(
        json_encode([
            "status" => "428",
        "status_text" => "Invalid Authorization",
        ]),
        428,
        [
            "Content-Type" => "application/json",
            "Cache-Control" => "no-cache, private",
        ]
    );

    $response->setStatusCode(428, "Precondition Required");
    $response->send();

    return null;
}

/*
 * Wrapper around JwtValidtor->decodeJwt();
 *
 * @param string $jwt
 * @return object
 */

function decode(string $jwt): object
{
    $decode = new JwtValidator($_ENV['JWT_SECRET']);
    $decode = $decode->decodeJwt($jwt);
    return $decode;
}
