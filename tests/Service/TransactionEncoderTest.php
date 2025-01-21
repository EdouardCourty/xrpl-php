<?php

declare(strict_types=1);

namespace XRPL\Tests\Service;

use PHPUnit\Framework\TestCase;
use XRPL\Service\TransactionEncoder;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Service\TransactionEncoder
 */
class TransactionEncoderTest extends TestCase
{
    private const string ADDRESS_1_SEED = 'sEdSgVhT1uGZErffGfLHX61ZkjAtPg2';

    private const string ADDRESS_1 = 'rNuaFncML9vq15nzEZd828h3K7x9ipN3xj';
    private const string ADDRESS_2 = 'r4vn5qzVo6qMiGxowbGV7QXm2N9VsdMFVc';

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

    /**
     * @covers ::encodeForSingleSign
     * @covers ::computeSignature
     * @covers ::sortFields
     * @covers ::serializeFields
     */
    public function testEncodeSingleSign(): void
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
            'TransactionType' => 'Payment',
            'Account' => self::ADDRESS_1,
            'Destination' => self::ADDRESS_2,
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
            '1200002400025C36201B0006F85561D3038D7EA4C6800000000000000000000000000055534400000000005E7B112523F68D2F5E879DB4EAC51C6698A6930468400000000000000C7321EDEA366EAD792FDEAE00C7A32B49E3EF763EEE5BDD30CDA7586D5C8FE04A8EDC937440A64110A0AA4FD013D1C9745D78A5EE4E0B0D583E68BB4D9B7E321FE98F81D8524661493ADE0BDADC323CDE290BE8AB21041C0E965387482E5933237EB2F0380B811498741DD80730B0E3F993BE2D4C5090EF7EB2D1128314F064A0F32B2A2BE3552FAA7F9077C45BDEA3021DF9EA7C0522222222227D0511111111117E050000000000E1EA7C0544444444447D0533333333337E055555555555E1F1',
            $blob,
        );
    }

    /**
     * @covers ::encodeForMultiSign
     * @covers ::computeSignature
     * @covers ::sortFields
     * @covers ::serializeFields
     */
    public function testEncodeMultiSign(): void
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
            'TransactionType' => 'Payment',
            'Account' => self::ADDRESS_1,
            'Destination' => self::ADDRESS_2,
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

        $blob = TransactionEncoder::encodeForMultiSign($transactionData, $wallet);

        $this->assertEquals(
            '1200002400025C36201B0006F85561D3038D7EA4C6800000000000000000000000000055534400000000005E7B112523F68D2F5E879DB4EAC51C6698A6930468400000000000000C7300811498741DD80730B0E3F993BE2D4C5090EF7EB2D1128314F064A0F32B2A2BE3552FAA7F9077C45BDEA3021DF3E0107321EDEA366EAD792FDEAE00C7A32B49E3EF763EEE5BDD30CDA7586D5C8FE04A8EDC9374403B7DAB54CDF856BC2E55884838E4C6B654DEC2086237CB05E0F08669C3B1B427E122A78C07029F7E541262E8248AA44B75D08B5011530B4FBDD40E7B842EBF05811498741DD80730B0E3F993BE2D4C5090EF7EB2D112E1F1F9EA7C0522222222227D0511111111117E050000000000E1EA7C0544444444447D0533333333337E055555555555E1F1',
            $blob,
        );
    }
}
