<?php

declare(strict_types=1);

namespace XRPL\Tests\Service;

use PHPUnit\Framework\TestCase;
use XRPL\Client\XRPLClient;
use XRPL\Service\TransactionEncoder;
use XRPL\ValueObject\Wallet;

/**
 * @coversDefaultClass \XRPL\Service\TransactionEncoder
 */
class TransactionEncoderTest extends TestCase
{
    private const string ADDRESS_1_SEED = 'sEdSgVhT1uGZErffGfLHX61ZkjAtPg2';

    private const string ADDRESS_1 = 'rNuaFncML9vq15nzEZd828h3K7x9ipN3xj';
    private const string ADDRESS_2 = 'r4vn5qzVo6qMiGxowbGV7QXm2N9VsdMFVc';

    /**
     * @covers ::encodeForSingleSign
     * @covers ::sortFields
     * @covers ::computeSignature
     */
    public function testItEncodesPayment(): void
    {
        $transactionData = [
            'Memos' => [
                [
                    'Memo' => [
                        'MemoData' => '1111111111',
                        'MemoType' => '2222222222',
                        'MemoFormat' => '0000000000',
                    ],
                ], [
                    'Memo' => [
                        'MemoData' => '3333333333',
                        'MemoType' => '4444444444',
                        'MemoFormat' => '5555555555',
                    ],
                ],
            ],
            'ObjectEndMarker' => [],
            'Account' => 'rNuaFncML9vq15nzEZd828h3K7x9ipN3xj',
            'Destination' => 'r4vn5qzVo6qMiGxowbGV7QXm2N9VsdMFVc',
            'Amount' => [
                'currency' => 'USD',
                'value' => '0.000001',
                'issuer' => 'r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59',
            ],
            'Fee' => '12',
            'Sequence' => 154678,
            'LastLedgerSequence' => 456789,
            'Validation' => uniqid(), // Should be ignored (non signing field, would fail the test if not)
        ];

        $wallet = Wallet::generateFromSeed(self::ADDRESS_1_SEED);

        // Make sure the signing wallet address is the same as the one in the transaction data
        $this->assertEquals(self::ADDRESS_1, $wallet->getAddress());

        $blob = TransactionEncoder::encodeForSingleSign($transactionData, $wallet);

        $this->assertEquals(
            '2400025C36201B0006F85561D3038D7EA4C6800000000000000000000000000055534400000000005E7B112523F68D2F5E879DB4EAC51C6698A6930468400000000000000C7321EDEA366EAD792FDEAE00C7A32B49E3EF763EEE5BDD30CDA7586D5C8FE04A8EDC93744035A0B2B24734F2DAC9F1551520D15611A09D400D734C6E6DCD8475452A8A37F000454B1AED71C40CE8E908CD2740B46F638419ACCCF1AA68E49AAA62048D5B04811498741DD80730B0E3F993BE2D4C5090EF7EB2D1128314F064A0F32B2A2BE3552FAA7F9077C45BDEA3021DE1F9EA7C0522222222227D0511111111117E050000000000E1EA7C0544444444447D0533333333337E055555555555E1F1',
            $blob,
        );
    }

    /**
     * @covers ::getSigningFields
     */
    public function testItIgnoresNonSigningFields(): void
    {
        $transactionData = [
            'Validation' => 'Data', // Should be ignored (non signing field)
            'TransactionType' => 'Payment',
            'Account' => self::ADDRESS_1,
        ];

        $fields = TransactionEncoder::getSigningFields($transactionData);

        $this->assertArrayNotHasKey('Validation', $fields);
    }
}
