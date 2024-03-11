<?php

declare(strict_types=1);

namespace Cepd\PokemonIntegration\Plugin;

use Cepd\PokemonIntegration\Model\PokemonProvider;
use Magento\Catalog\Block\Product\View\Gallery;
use Magento\Framework\Data\Collection;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;

class ProductGalleryPlugin
{
    /**
     * @param PokemonProvider $pokemonProvider
     */
    public function __construct(
        protected PokemonProvider $pokemonProvider,
        protected CacheInterface $cache,
        protected SerializerInterface $serializer
    ) {}

    public function afterGetGalleryImages(Gallery $subject, Collection $result): Collection
    {
        $pokemonName = $subject->getProduct()->getData('pokemon_name');
        if (!empty($pokemonName)) {
            $pokemonData = $this->pokemonProvider->getPokemonClient($pokemonName);
            $pokemonImageUrl = $pokemonData['sprites']['front_default'];
    
            foreach ($result->getItems() as $image) {
                $image->setData('medium_image_url', $pokemonImageUrl);
                $image->setData('large_image_url', $pokemonImageUrl);
                $image->setData('small_image_url', $pokemonImageUrl);
            }
        }
        return $result;
    }
}
