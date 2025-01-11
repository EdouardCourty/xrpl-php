<?php
declare(strict_types=1);

namespace XRPL\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
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
}
