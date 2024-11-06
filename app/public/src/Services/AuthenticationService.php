<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Authentication\InvalidCredentialsException;
use App\Exceptions\Users\InvalidLoginDetailsException;
use App\Repositories\AppRepository;
use Firebase\JWT\JWT;

class AuthenticationService
{
    /** @var AppRepository $appRepository */
    private AppRepository $appRepository;

    /** @var string $jwtSecret */
    private string $jwtSecret;

    /**
     * @param AppRepository $appRepository
     * @param string $jwtSecret
     */
    public function __construct(AppRepository $appRepository, string $jwtSecret)
    {
        $this->appRepository = $appRepository;
        $this->jwtSecret = $jwtSecret;
    }

    /**
     * @throws InvalidCredentialsException
     * @return string
     */
    public function authenticate(string $app_id, string $app_secret): string
    {
        $app = $this->appRepository->findAppByKeys($app_id, $app_secret);
        if (!$app) {
            throw new InvalidCredentialsException("Invalid keys.");
        }

        $token = JWT::encode(
            [
                "appId" => $app->getId(),
                "iat" => time(),
                "exp" => time() + 3600,
            ],
            $this->jwtSecret,
            "HS256"
        );

        return $token;
    }
}
