<?php

namespace Cepd\PokemonIntegration\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Cepd\PokemonIntegration\Model\PokemonProvider;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Image;

class ProductImagePlugin
{
    /**
     * @param ProductRepositoryInterface $productRepository
     * @param PokemonProvider $pokemonProvider
     */
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private PokemonProvider $pokemonProvider
    ) {}
    
    public function afterGetImage(AbstractProduct $subject, Image $result): Image
    {
        $productId = $result->getProductId();
        $product = $this->productRepository->getById($productId);
    
        if ($pokemonName = $product->getData('pokemon_name')) {
            $pokemonData = $this->pokemonProvider->getPokemonClient($pokemonName);
            $productImage = $pokemonData['sprites']['front_default'];
            $result->setImageUrl($productImage);
        }
    
        return $result;
    }
}
