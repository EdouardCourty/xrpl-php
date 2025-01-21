<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\AccountID;
use XRPL\Type\Currency;
use XRPL\Type\STIssue;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\STIssue
 */
class STIssueTest extends TestCase
{
    public function testSTIssue(): void
    {
        $currency = new Currency('USD');
        $issuer = new AccountID('rfqiBEj3Rr9zSWLsYwC284Gcbippbi1jRQ');
        $issue = new STIssue($currency, $issuer);

        $this->assertEquals(
            '00000000000000000000000055534400000000004B0DC586B539B7FED11062802F573A3ABCECE0B7',
            $issue->toSerialized(),
        );
    }
}
