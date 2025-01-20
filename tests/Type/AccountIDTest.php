<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\AccountID;

/**
 * @coversDefaultClass \XRPL\Type\AccountID
 */
class AccountIDTest extends TestCase
{
    public function testAccountId(): void
    {
        $accountId = new AccountID('rfqiBEj3Rr9zSWLsYwC284Gcbippbi1jRQ');

        $this->assertEquals('4B0DC586B539B7FED11062802F573A3ABCECE0B7', $accountId->toSerialized());
    }
}
