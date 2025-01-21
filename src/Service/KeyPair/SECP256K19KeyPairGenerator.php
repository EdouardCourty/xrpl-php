<?php

declare(strict_types=1);

namespace XRPL\Service\KeyPair;

use BN\BN;
use Elliptic\EC;
use XRPL\Helper\Cryptography;
use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 */
class SECP256K19KeyPairGenerator extends AbstractAlgorithmAwareKeyPairGenerator
{
    private readonly EC $elliptic;

    public function __construct()
    {
        $this->elliptic = new EC(Wallet::ALGORITHM_SECP256K1);
    }

    public function deriveKeyPair(Seed $seed, bool $validator = false, int $index = 0): KeyPair
    {
        $payload = $seed->payload;

        $privateKey = $this->derivePrivateKey($payload, $validator, $index);
        $publicKey = $this->elliptic->g->mul(new BN($privateKey, 16))->encodeCompressed('hex');

        return new KeyPair(parent::PREFIX_SECP256K1 . strtoupper($privateKey), strtoupper($publicKey));
    }

    private function derivePrivateKey(array $seedPayload, bool $validator, int $index): string
    {
        $privateKeyGenerator = $this->getNumberGenerator($seedPayload);

        if ($validator) {
            return $privateKeyGenerator->toString('hex');
        }

        $publicKeyGenerator = $this->elliptic->g->mul($privateKeyGenerator);

        $byteArray = Cryptography::byteStringToArray($publicKeyGenerator->encodeCompressed('hex'));

        return $this->getNumberGenerator($byteArray, $index)
            ->add($privateKeyGenerator)
            ->mod($this->elliptic->n)
            ->toString('hex');
    }

    public function getNumberGenerator(array $data, ?int $discriminator = null): BN
    {
        $zeroBN = new BN(0);
        $seqBN = $zeroBN->_clone();

        while (true) {
            $seedArray = $data;

            if (\is_int($discriminator)) {
                $seedArray = array_merge($seedArray, Cryptography::byteStringToArray('00000000'));
            }

            $seqHex = str_pad($seqBN->toString('hex'), 8, '00', \STR_PAD_LEFT);
            $seedArray = array_merge($seedArray, Cryptography::byteStringToArray($seqHex));

            $hash = bin2hex(Cryptography::halfSha512(Cryptography::byteArrayToString($seedArray)));
            $hashBN = new BN($hash, 16);

            if($hashBN->cmp($zeroBN) != 0 && $hashBN->cmp($this->elliptic->n) < 0) {
                return $hashBN;
            }

            $seqBN = $seqBN->add(1);
        }
    }

    public function sign(string $message, string $privateKey): string
    {
        $hash = Cryptography::halfSha512($message);

        return $this->elliptic->sign(
            $hash,
            $privateKey,
            'hex',
            ['canonical' => true],
        )->toDER('hex');
    }
}
