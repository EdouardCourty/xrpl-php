<?php

declare(strict_types=1);

namespace XRPL\Tests\ValueObject;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Service\Wallet\Seeder;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @coversDefaultClass \XRPL\ValueObject\Seed
 */
class SeedTest extends TestCase
{
    /**
     * @covers ::isValid
     */
    #[DataProvider('provideSeeds')]
    public function testValidation(Seed $seed, bool $shouldValidate): void
    {
        $this->assertSame($shouldValidate, $seed->isValid());
    }

    /**
     * @return iterable<array{Seed, bool}>
     */
    public static function provideSeeds(): iterable
    {
        // Valid seed
        $validSeed = Seeder::generateSeed(Wallet::ALGORITHM_ED25519);
        yield [$validSeed, true];

        // Invalid seed: wrong checksum
        $invalidSeed = new Seed($validSeed->algorithm, $validSeed->prefix, $validSeed->payload, [1]);
        yield [$invalidSeed, false];

        // Invalid seed: wrong payload
        $invalidSeed = new Seed($validSeed->algorithm, $validSeed->prefix, [1, 2, 3, 4, 5, 6, 7, 8, 19, 10], $validSeed->checksum);
        yield [$invalidSeed, false];

        // Invalid seed: wrong prefix
        $invalidSeed = new Seed($validSeed->algorithm, [1567], $validSeed->payload, $validSeed->checksum);
        yield [$invalidSeed, false];
    }

    /**
     * @covers ::toString
     * @covers ::__toString
     */
    #[DataProvider('provideValidSeedStrings')]
    public function testToString(string $seedString): void
    {
        $seed = Seeder::generateSeedFromString($seedString);

        $this->assertSame($seedString, (string) $seed);
        $this->assertSame($seedString, $seed->toString());
    }

    public static function provideValidSeedStrings(): iterable
    {
        yield ['sEdVGHpyraFT5a24PGvfYa26tLLDfKj'];
        yield ['shAn5KQML2FF1aBmSA2g9HNJztJ6f'];
    }
}
