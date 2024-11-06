<?php

namespace App\Contracts;

use App\Exceptions\Jwt\InvalidJwtClaimException;
use App\Exceptions\Jwt\InvalidJwtSignatureException;
use App\Exceptions\Jwt\JwtDecodingException;

interface IJwtValidator
{
    /**
     * Decodes and verifies the JWT.
     *
     * @param string $jwt The JWT payload from the client.
     * @throws InvalidJwtSignatureException If the signature is invalid.
     * @throws JwtDecodingException If the JWT cannot be decoded.
     * @return object The decoded JWT payload.
     */
    public function decodeJwt(string $jwt): object;

    /**
     * Validates the claims sent by the client.
     *
     * @param int $expirationTime The expiration time claim (`exp`) in the token.
     * @throws InvalidJwtClaimException If the claim is invalid (e.g., expired).
     * @return bool True if claims are valid, false otherwise.
     */
    public function validateClaims(int $expirationTime): bool;
}
