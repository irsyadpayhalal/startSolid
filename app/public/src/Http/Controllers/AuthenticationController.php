<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use App\Exceptions\MissingParameterException;

class AuthenticationController
{
    /** @var AuthenticationService $authenticationService */
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     *
     * @param string $reqJson
     *
     * @return string
     * @throws MissingParameterException
     */
    public function authenticate(string $reqJson): string
    {
        if (empty($reqJson)) {
            throw new MissingParameterException("JSON payload not passed");
        }

        $req_data = json_decode($reqJson, true);
        if (!is_array($req_data)) {
            throw new MissingParameterException("Invalid JSON format");
        }

        if (!isset($req_data["app_id"]) || !isset($req_data["app_secret"])) {
            throw new MissingParameterException(
                "Required parameters 'app_id' and 'app_secret' are missing"
            );
        }

        $appId = $req_data["app_id"];
        $appSecret = $req_data["app_secret"];

        if (!is_string($appId) || !is_string($appSecret)) {
            throw new MissingParameterException(
                "Invalid parameter types for 'app_id' or 'app_secret'"
            );
        }

        return $this->authenticationService->authenticate($appId, $appSecret);
    }
}
