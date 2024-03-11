<?php

declare(strict_types=1);

namespace Cepd\PokemonIntegration\Model;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    private const METHOD_KEY_ACTIVE = 'catalog/pokemon_configuration/enabled';
    private const API_URL = 'catalog/pokemon_configuration/api_url';

    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {}

    /**
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(self::METHOD_KEY_ACTIVE, ScopeInterface::SCOPE_STORE);    
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->scopeConfig->getValue(static::API_URL, ScopeInterface::SCOPE_WEBSITE) ?: '';
    }
}
