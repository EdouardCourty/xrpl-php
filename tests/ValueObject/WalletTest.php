<?php

declare(strict_types=1);

namespace XRPL\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\ValueObject\Wallet
 */
class WalletTest extends TestCase
{
    /**
     * Ensures the Wallet facade methods return the exact same thing as the WalletGenerator.
     *
     * @covers ::generateFromSeed
     */
    public function testGeneration(): void
    {
        $seed = 'shAn5KQML2FF1aBmSA2g9HNJztJ6f';

        $wallet = Wallet::generateFromSeed($seed);
        $wallet2 = WalletGenerator::generateFromSeed($seed);

        $this->assertEquals($wallet, $wallet2);
    }

    /**
     * Ensure two randomly generated wallets are different.
     *
     * @covers ::generate
     */
    public function testGenerateRandom(): void
    {
        $wallet = Wallet::generate();
        $wallet2 = WalletGenerator::generate();

        $this->assertNotEquals($wallet, $wallet2);
    }
}
