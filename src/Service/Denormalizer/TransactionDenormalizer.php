<?php

declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use XRPL\Enum\TransactionTypeEnum;
use XRPL\Model\AbstractTransaction;
use XRPL\Service\Serializer;

readonly class TransactionDenormalizer
{
    public function __construct(private Serializer $serializer)
    {
    }

    public function denormalize(array $data): AbstractTransaction
    {
        $transactionType = TransactionTypeEnum::tryFrom($data['TransactionType']) ?: TransactionTypeEnum::Unknown;

        return $this->serializer->deserialize(json_encode($data), $transactionType->getClass(), 'json');
    }

    /**
     * @param \stdClass[] $data
     * @return AbstractTransaction[]
     */
    public function deserializeList(array $data): array
    {
        if (empty($data)) {
            return [];
        }

        if ($data[0] instanceOf \stdClass) {
            $data = json_decode(json_encode($data), true);
        }

        return array_map(fn(array $transaction) => $this->denormalize($transaction), $data);
    }

    /**
     * @param \stdClass[] $data
     * @return AbstractTransaction[]
     */
    public function deserializeListForAccount(array $data): array
    {
        if (empty($data)) {
            return [];
        }

        if ($data[0] instanceOf \stdClass) {
            $data = json_decode(json_encode($data), true);
        }

        return array_map(fn(array $transaction) => $this->denormalize($transaction['tx']), $data);
    }
}
