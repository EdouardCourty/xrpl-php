<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Wallet;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
 * @coversDefaultClass \XRPL\Service\Wallet\WalletGenerator
 */
class WalletGeneratorTest extends TestCase
{
    /**
     * @covers ::generate
     */
    public function testGenerateWalletWithInvalidAlgorithm(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        WalletGenerator::generate('invalid');
    }

    #[DataProvider('provideAlgorithms')]
    public function testGenerateWallet(string $algorithm): void
    {
        $wallet = WalletGenerator::generate($algorithm);

        $this->assertWallet($wallet, $algorithm);
    }

    private function assertWallet(Wallet $wallet, string $algorithm): void
    {
        $this->assertNotEmpty($wallet->keyPair->publicKey);
        $this->assertNotEmpty($wallet->keyPair->privateKey);

        $this->assertNotEmpty($wallet->seed->toString());
        $this->assertNotEmpty($wallet->getAddress());

        $this->assertEquals($algorithm, $wallet->seed->algorithm);
    }

    /**
     * @return iterable<string>
     */
    public static function provideAlgorithms(): iterable
    {
        foreach (Wallet::ALGORITHMS as $algorithm) {
            yield [$algorithm];
        }
    }
}
