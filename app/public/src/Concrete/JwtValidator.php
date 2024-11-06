<?php

namespace App\Concrete;

use App\Contracts\IJwtValidator;
use App\Exceptions\Jwt\InvalidJwtClaimException;
use App\Exceptions\Jwt\InvalidJwtSignatureException;
use App\Exceptions\Jwt\JwtDecodingException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtValidator implements IJwtValidator
{
    /** @var string $key */
    private string $key;

    /** @var string $algorithm */
    private string $algorithm;

    /**
     * @param string $key The key injected by PHP-DI for signature verification.
     * @param string $algorithm The algorithm to use for verification (default: HS256).
     */
    public function __construct(string $key, string $algorithm = "HS256")
    {
        $this->key = $key;
        $this->algorithm = $algorithm;
    }

    /**
     * Decodes and verifies the JWT.
     *
     * @param string $jwt The JWT payload from the client.
     * @throws InvalidJwtSignatureException If the signature is invalid.
     * @throws JwtDecodingException If the JWT cannot be decoded.
     * @return object The decoded JWT payload.
     */
    public function decodeJwt(string $jwt): object
    {
        try {
            return JWT::decode($jwt, new Key($this->key, $this->algorithm));
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            throw new InvalidJwtSignatureException("Invalid JWT signature");
        } catch (\Exception $e) {
            throw new JwtDecodingException(
                "Error decoding JWT: " . $e->getMessage()
            );
        }
    }

    /**
     * Validates the claims sent by the client.
     *
     * @param int $expirationTime The expiration time claim (`exp`) in the token.
     * @throws InvalidJwtClaimException If the claim is invalid (e.g., expired).
     * @return bool True if claims are valid, false otherwise.
     */
    public function validateClaims(int $expirationTime): bool
    {
        if ($expirationTime < time()) {
            throw new InvalidJwtClaimException("Token has expired");
        }

        return true;
    }
}
