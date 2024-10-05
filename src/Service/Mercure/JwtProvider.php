<?php

namespace App\Service\Mercure;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Symfony\Component\Mercure\Jwt\TokenProviderInterface;

class JwtProvider implements TokenProviderInterface
{
    public function __construct(protected string $mercureSecretKey)
    {
    }

    public function getJwt(): string
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->mercureSecretKey)
        );

        return $configuration
            ->builder()
            ->withClaim('mercure', ['publish' => ['*']])
            ->getToken(
                $configuration->signer(),
                $configuration->signingKey()
            )
            ->toString();
    }
}