<?php

declare(strict_types=1);

namespace XRPL\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use XRPL\Service\Wallet\Seeder;
use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
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

        KeyPair::generate(Wallet::ALGORITHM_ED25519);
    }

    /**
     * @covers ::generateFromSeed
     */
    public function testItGeneratesFromSeed(): void
    {
        $seed = Seeder::generateSeed(Wallet::ALGORITHM_ED25519);

        $keypair = KeyPair::generateFromSeed($seed);
        $keypair2 = WalletGenerator::generateFromSeed($seed)->keyPair;

        $this->assertEquals($keypair, $keypair2);
    }
}
