<?php

declare(strict_types=1);

namespace Cepd\PokemonIntegration\Model;

use Cepd\PokemonIntegration\Model\ConfigProvider;
use Cepd\PokemonIntegration\Model\PokemonProviderFactory;
use Psr\Log\LoggerInterface;

class PokemonProvider
{
    /**
     * @param ConfigProvider $configuration
     * @param PokemonProviderFactory $pokemonProviderFactory
     */
    public function __construct(
        private ConfigProvider $configuration,
        protected PokemonProviderFactory $pokemonProviderFactory,
        protected LoggerInterface $logger
    ) {}

    public function getPokemonClient($pokemonName)
    {
        if (!$this->configuration->isEnabled()) {
            return null;
        }
        if (!isset($this->pokemonClient)) {
            $this->pokemonClient = $this->pokemonProviderFactory->create();
        }
        $url = $this->configuration->getApiUrl() . $pokemonName;
        try {
            $response = $this->pokemonClient->request('GET', $url);
            if ($response->getStatusCode() == 200) {
                return json_decode((string) $response->getBody(), true);
            } else {
                $this->logger->error('Error response from PokeAPI: ' . $response->getBody());
                return null;
            }
        } catch (\Exception $e) {
            $this->logger->error('GuzzleHttp exception: ' . $e->getMessage());
            return null;
        }
    }
}
