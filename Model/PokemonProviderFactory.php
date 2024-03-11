<?php

declare(strict_types=1);

namespace Cepd\PokemonIntegration\Model;

use Magento\Framework\ObjectManagerInterface;
use Cepd\PokemonIntegration\Api\Data\PokemonProviderFactoryInterface;
use GuzzleHttp\Client;

class PokemonProviderFactory implements PokemonProviderFactoryInterface
{   
    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        private  ObjectManagerInterface $objectManager
    ) {}

    public function create(): Client
    {
        return $this->objectManager->create(Client::class);
    }
}
