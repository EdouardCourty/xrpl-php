<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Wallet;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Enum\Algorithm;
use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Service\Wallet\WalletGenerator
 */
class WalletGeneratorTest extends TestCase
{
    private const string SEED_WALLET_EC25519 = 'sEdVGHpyraFT5a24PGvfYa26tLLDfKj';
    private const string SEED_WALLET_SECP256K1 = 'shAn5KQML2FF1aBmSA2g9HNJztJ6f';

    #[DataProvider('provideAlgorithms')]
    public function testGenerateWallet(Algorithm $algorithm): void
    {
        $wallet = WalletGenerator::generate($algorithm);

        $this->assertWallet($wallet, $algorithm);
    }

    private function assertWallet(Wallet $wallet, Algorithm $algorithm): void
    {
        $this->assertNotEmpty($wallet->getPublicKey());
        $this->assertNotEmpty($wallet->getPrivateKey());

        $this->assertNotEmpty($wallet->getSeedString());
        $this->assertNotEmpty($wallet->getAddress());

        $this->assertEquals($algorithm, $wallet->getAlgorithm());
    }

    public static function provideAlgorithms(): \Generator
    {
        foreach (Algorithm::cases() as $algorithm) {
            yield [$algorithm];
        }
    }

    /**
     * @covers ::generateFromSeed
     */
    #[DataProvider('provideSeedData')]
    public function testWalletGenerationFromSeed(
        string $seed,
        string $expectedAddress,
        string $expectedPublicKey,
        string $expectedPrivateKey,
    ): void {
        $wallet = WalletGenerator::generateFromSeed($seed);

        $this->assertEquals($expectedAddress, $wallet->getAddress());
        $this->assertEquals($expectedPublicKey, $wallet->getPublicKey());
        $this->assertEquals($expectedPrivateKey, $wallet->getPrivateKey());
    }

    public static function provideSeedData(): iterable
    {
        yield [
            self::SEED_WALLET_EC25519,
            'rJKiaAMWMWBJhGtUZEN4AfpwWaTSzJanFq',
            'ED1F3C3AECC9CDB30DB2EC9FD219E57067B505F004FADA57BA7206142F2F84E379',
            'ED2A80B5F75118EB93BDB53D7CCED51DB18F78975487161040EB276D5FBE65D25C',
        ];
        yield [
            self::SEED_WALLET_SECP256K1,
            'rwDEBXpEwRDfMV3zVY9HdeAxguy9XaDsE8',
            '027D8FAD8F6BB6BE9CB42B80AA4B5A47E7FED102866BC15A863BB423526197CF22',
            '007F28DF7FF8EBED085B528C9F45E82BA1AD7906B6FA0FBF9BCCA9B089205DD561',
        ];
    }
}
