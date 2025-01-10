<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Model\PaymentChannel\ChannelAuthorize;
use XRPL\Model\PaymentChannel\ChannelVerify;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class PaymentChannelClient extends AbstractClient
{
    public function authorizeChannel(
        string $channelId,
        string $amount,
        ?string $secret = null,
        ?string $seed = null,
        ?string $seedHex = null,
        ?string $passphrase = null,
    ): ChannelAuthorize {
        $providedParams = array_filter([
            'secret' => $secret,
            'seed' => $seed,
            'seed_hex' => $seedHex,
            'passphrase' => $passphrase,
        ]);

        if (\count($providedParams) > 1) {
            throw new \InvalidArgumentException(
                'Only one of $secret, $seed, $seedHex, $passphrase should be set.',
            );
        }

        $payload = [
            'channel_id' => $channelId,
            'amount' => $amount,
        ];

        if (!empty($providedParams)) {
            $key = key($providedParams);
            $value = reset($providedParams);

            $payload[$key] = $value;
        }

        $response = $this->jsonRpcClient->getResult('channel_authorize', $payload);

        return $this->serializer->deserialize(json_encode($response), ChannelAuthorize::class, 'json');
    }

    public function verifyChannel(
        string $amount,
        string $channelId,
        string $publicKey,
        string $signature,
    ): ChannelVerify {
        $payload = [
            'amount' => $amount,
            'channel_id' => $channelId,
            'public_key' => $publicKey,
            'signature' => $signature,
        ];

        $response = $this->jsonRpcClient->getResult('channel_verify', $payload);

        return $this->serializer->deserialize(json_encode($response), ChannelVerify::class, 'json');
    }
}
