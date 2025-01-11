<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Wallet;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Service\KeyPair\AbstractAlgorithmAwareKeyPairGenerator;
use XRPL\Service\Wallet\KeyPairGenerator;
use XRPL\Service\Wallet\Seeder;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
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
        $validSeed = Seeder::generateSeed(Wallet::ALGORITHM_ED25519);

        $invalidSeed = new Seed($validSeed->algorithm, $validSeed->prefix, [1, 2, 3, 4, 5, 6, 7, 8, 19, 10], $validSeed->checksum);
        $this->expectException(\UnexpectedValueException::class);

        KeyPairGenerator::generateKeyPair($invalidSeed);
    }

    /**
     * @covers ::generateKeyPair
     * @covers ::getKeypairGenerator
     */
    #[DataProvider('provideAlgorithms')]
    public function testGenerateKeyPair(string $algorithm): void
    {
        $seed = Seeder::generateSeed($algorithm);
        $keyPair = KeyPairGenerator::generateKeyPair($seed);

        $this->assertNotEmpty($keyPair->publicKey);
        $this->assertNotEmpty($keyPair->privateKey);

        $algorithmSeedPrefix = AbstractAlgorithmAwareKeyPairGenerator::PREFIX_MAPPING[$algorithm];
        $this->assertStringStartsWith($algorithmSeedPrefix, $keyPair->privateKey);
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
