<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Wallet;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Enum\Algorithm;
use XRPL\Service\Wallet\Seeder;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Service\Wallet\Seeder
 */
class SeederTest extends TestCase
{
    /**
     * @covers ::generateSeed
     * @covers ::getSeedPrefix
     */
    #[DataProvider('provideAlgorithms')]
    public function testGenerateSeed(Algorithm $algorithm): void
    {
        $seed = Seeder::generateSeed($algorithm);

        $this->assertTrue($seed->isValid());

        $this->assertSame($algorithm, $seed->algorithm);
        $this->assertSame($seed->prefix, $algorithm->getPrefix());
        $this->assertNotEmpty($seed->payload);
        $this->assertNotEmpty($seed->checksum);
    }

    public static function provideAlgorithms(): iterable
    {
        foreach (Algorithm::cases() as $algorithm) {
            yield [$algorithm];
        }
    }

    /**
     * @covers ::generateSeedFromString
     * @covers ::guessAlgorithm
     */
    #[DataProvider('provideSeedData')]
    public function testSeedDecoding(string $seedString, Algorithm $algorithm, array $payload, array $checksum): void
    {
        $seed = Seeder::generateSeedFromString($seedString);

        $this->assertTrue($seed->isValid());

        $this->assertSame($algorithm, $seed->algorithm);
        $this->assertSame($seed->prefix, $algorithm->getPrefix());
        $this->assertSame($seed->payload, $payload);
        $this->assertSame($seed->checksum, $checksum);
    }

    public static function provideSeedData(): iterable
    {
        yield [
            'sEdVGHpyraFT5a24PGvfYa26tLLDfKj',
            Algorithm::ED25519,
            [212, 218, 81, 19, 47, 115, 242, 172, 93, 206, 150, 135, 180, 128, 54, 34],
            [25, 162, 193, 198],
        ];

        yield [
            'shAn5KQML2FF1aBmSA2g9HNJztJ6f',
            Algorithm::SECP256K1,
            [160, 156, 176, 169, 112, 229, 129, 241, 23, 31, 213, 165, 136, 238, 197, 15],
            [161, 77, 177, 226],
        ];
    }
}
