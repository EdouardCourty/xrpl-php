<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Wallet;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Service\Wallet\AddressService;
use XRPL\Service\Wallet\WalletGenerator;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Service\Wallet\AddressService
 */
class AddressServiceTest extends TestCase
{
    /**
     * @covers ::deriveAddress
     */
    #[DataProvider('generateDataForAddressDerivation')]
    public function testAddressDerivation(string $seed, string $expectedAddress): void
    {
        $wallet = WalletGenerator::generateFromSeed($seed);
        $computedAddress = AddressService::deriveAddress($wallet->getPublicKey());

        $this->assertSame($computedAddress, $expectedAddress);
    }

    public static function generateDataForAddressDerivation(): \Generator
    {
        yield ['sEdVGHpyraFT5a24PGvfYa26tLLDfKj', 'rJKiaAMWMWBJhGtUZEN4AfpwWaTSzJanFq'];
        yield ['shAn5KQML2FF1aBmSA2g9HNJztJ6f', 'rwDEBXpEwRDfMV3zVY9HdeAxguy9XaDsE8'];
    }
}
