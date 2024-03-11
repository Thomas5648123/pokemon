<?php

declare(strict_types=1);

namespace Cepd\PokemonIntegration\Api\Data;

use GuzzleHttp\Client;

interface PokemonProviderFactoryInterface
{
    /**
     * Create a new instance
     *
     * @return Client
     */
    public function create(): Client;
}
