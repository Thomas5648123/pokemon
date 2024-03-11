<?php

declare(strict_types=1);

namespace Cepd\PokemonIntegration\Test\Unit\Model;

use Cepd\PokemonIntegration\Model\ConfigProvider;
use Cepd\PokemonIntegration\Model\PokemonProvider;
use Cepd\PokemonIntegration\Model\PokemonProviderFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

class PokemonProviderTest extends TestCase
{
    protected $configProviderMock;
    protected $pokemonProviderFactoryMock;
    protected $loggerMock;
    protected $clientMock;
    protected $responseMock;

    protected function setUp(): void
    {
        $this->configProviderMock = $this->createMock(ConfigProvider::class);
        $this->pokemonProviderFactoryMock = $this->createMock(PokemonProviderFactory::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->clientMock = $this->createMock(ClientInterface::class);
        $this->responseMock = $this->createMock(Response::class);
    }

    public function testGetPokemonClientWhenDisabled()
    {
        $this->configProviderMock->method('isEnabled')
            ->willReturn(false);

        $pokemonProvider = new PokemonProvider(
            $this->configProviderMock,
            $this->pokemonProviderFactoryMock,
            $this->loggerMock
        );

        $result = $pokemonProvider->getPokemonClient('pikachu');
        $this->assertNull($result);
    }

    public function testGetPokemonClientWhenEnabled()
    {
        $this->configProviderMock->method('isEnabled')
            ->willReturn(true);

        $pokemonProvider = new PokemonProvider(
            $this->configProviderMock,
            $this->pokemonProviderFactoryMock,
            $this->loggerMock
        );

        $this->pokemonProviderFactoryMock->method('create')
            ->willReturn($this->clientMock);

        $this->responseMock->method('getStatusCode')
            ->willReturn(200);
        $this->responseMock->method('getBody')
            ->willReturn(json_encode(['name' => 'pikachu']));

        $this->clientMock->method('request')
            ->willReturn($this->responseMock);

        $result = $pokemonProvider->getPokemonClient('pikachu');
        $this->assertEquals(['name' => 'pikachu'], $result);
    }
}
