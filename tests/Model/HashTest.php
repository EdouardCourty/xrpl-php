<?php

declare(strict_types=1);

namespace XRPL\Tests\Model;

use PHPUnit\Framework\TestCase;
use XRPL\src\Type\Hash;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
 * @coversDefaultClass \XRPL\src\Type\Hash
 */
class HashTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testShouldThrowIfLengthTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Hash('1234567890');
    }

    /**
     * @covers ::__construct
     */
    public function testShouldThrowIfLengthTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Hash('123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890');
    }

    /**
     * @covers ::__construct
     */
    public function testShouldNotThrowIfLengthOkay(): void
    {
        $this->expectNotToPerformAssertions();

        new Hash(implode(array_fill(0, 64, 'A')));
    }

    public function testShouldThrowIfWrongCharactersArePassed(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Hash('WRONG_CHARACTERS_HERE_WRONG_CHARACTERS_HERE_WRONG_CHARACTERS_HERE_');
    }
}
