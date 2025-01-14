<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Signature;

use PHPUnit\Framework\TestCase;
use XRPL\Service\Signature\ServerDefinitions;

/**
 * @coversDefaultClass \XRPL\Service\Signature\ServerDefinitions
 */
class ServerDefinitionsTest extends TestCase
{
    public function testItGetsTheCorrectField(): void
    {
        $field = ServerDefinitions::getInstance()->getFieldDefinition('Account');

        $this->assertEquals('Account', $field->name);
        $this->assertEquals(1, $field->nth);
        $this->assertTrue($field->isSigningField);
        $this->assertTrue($field->isVLEncoded);
        $this->assertTrue($field->isSerialized);
        $this->assertEquals('AccountID', $field->type);
        $this->assertEquals(8, $field->typeCode);
    }
}
