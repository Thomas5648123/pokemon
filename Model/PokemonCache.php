<?php

namespace Cepd\PokemonIntegration\Model;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;
use Magento\Framework\App\Cache\Type\FrontendPool;

class PokemonCache extends TagScope
{
    const CACHE_TAG = 'pokemon_data';
    const TYPE_IDENTIFIER = 'pokemon_data';

  /**
     * @param FrontendPool $cacheFrontendPool
     */
    public function __construct(FrontendPool $cacheFrontendPool)
    {
        parent::__construct(
            $cacheFrontendPool->get(self::TYPE_IDENTIFIER),
            self::CACHE_TAG
        );
    }
}
