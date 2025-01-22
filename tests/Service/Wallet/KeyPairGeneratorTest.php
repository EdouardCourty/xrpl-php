<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Wallet;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Enum\Algorithm;
use XRPL\Service\Wallet\KeyPairGenerator;
use XRPL\Service\Wallet\Seeder;
use XRPL\ValueObject\Seed;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Service\Wallet\KeyPairGenerator
 */
class KeyPairGeneratorTest extends TestCase
{
    /**
     * @covers ::generateKeyPair
     */
    public function testGenerateKeyPairWithInvalidSeed(): void
    {
        $validSeed = Seeder::generateSeed(Algorithm::ED25519);

        $invalidSeed = new Seed($validSeed->algorithm, $validSeed->prefix, [1, 2, 3, 4, 5, 6, 7, 8, 19, 10], $validSeed->checksum);
        $this->expectException(\UnexpectedValueException::class);

        KeyPairGenerator::generateKeyPair($invalidSeed);
    }

    /**
     * @covers ::generateKeyPair
     * @covers ::getKeypairGenerator
     */
    #[DataProvider('provideAlgorithms')]
    public function testGenerateKeyPair(Algorithm $algorithm): void
    {
        $seed = Seeder::generateSeed($algorithm);
        $keyPair = KeyPairGenerator::generateKeyPair($seed);

        $this->assertNotEmpty($keyPair->getPublicKey());
        $this->assertNotEmpty($keyPair->getPrivateKey());

        $algorithmSeedPrefix = $algorithm->getKeyPrefix();
        $this->assertStringStartsWith($algorithmSeedPrefix, $keyPair->getPrivateKey()); // @phpstan-ignore-line
    }

    public static function provideAlgorithms(): \Generator
    {
        foreach (Algorithm::cases() as $algorithm) {
            yield [$algorithm];
        }
    }
}
