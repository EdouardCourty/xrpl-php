<?php

declare(strict_types=1);

namespace XRPL\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use XRPL\Enum\Algorithm;
use XRPL\Service\Wallet\Seeder;
use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\KeyPair;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\ValueObject\KeyPair
 */
class KeyPairTest extends TestCase
{
    /**
     * @covers ::generate
     */
    public function testItGeneratesKeyPair(): void
    {
        $this->expectNotToPerformAssertions();

        KeyPair::generate(Algorithm::ED25519);
    }

    /**
     * @covers ::generateFromSeed
     */
    public function testItGeneratesFromSeed(): void
    {
        $seed = Seeder::generateSeed(Algorithm::ED25519);

        $keypair = KeyPair::generateFromSeed($seed);
        $keypair2 = WalletGenerator::generateFromSeed($seed)->keyPair;

        $this->assertEquals($keypair, $keypair2);
    }
}
