<?php

declare(strict_types=1);

namespace Cepd\PokemonIntegration\Plugin\Catalog\Model;

use Magento\Catalog\Model\Product;
use Cepd\PokemonIntegration\Model\PokemonProvider;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;

class PokemonProduct
{
    /**
     * @param PokemonProvider $pokemonProvider
     */
    public function __construct(
        protected PokemonProvider $pokemonProvider,
        protected CacheInterface $cache,
        protected SerializerInterface $serializer
    ) {}

    public function afterGetName(Product $subject, string $result): string
    {
        $pokemonName = $subject->getData('pokemon_name');
        $cachedPokemonData = $this->cache->load('pokemon_data');

        if ($cachedPokemonData !== false) {
            return $this->serializer->unserialize($cachedPokemonData);
        }

        if ($pokemonName) {
            $pokemonData = $this->pokemonProvider->getPokemonClient($pokemonName);
            if ($pokemonName && $pokemonData && isset($pokemonData['name'])) {

                $this->cache->save(
                    $this->serializer->serialize($pokemonData['name']),
                    'pokemon_data',
                    ['pokemon_data'],
                    86400
                );
                return $pokemonData['name'];
            }
        }
        return $result;
    }
}
