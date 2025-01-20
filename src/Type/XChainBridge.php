<?php

declare(strict_types=1);

namespace XRPL\Type;

class XChainBridge extends AbstractBinaryType
{
    public function __construct(
        AccountID $lockingChainDoor,
        STIssue $lockingChainDoorIssue,
        AccountID $issuingChainDoor,
        STIssue $issuingChainAssetType,
    ) {
        parent::__construct(array_merge(
            [$lockingChainDoor->getLength()],
            $lockingChainDoor->getBytes(),
            $lockingChainDoorIssue->getBytes(),
            [$issuingChainDoor->getLength()],
            $issuingChainDoor->getBytes(),
            $issuingChainAssetType->getBytes(),
        ));
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_array($data) === false) {
            throw new \InvalidArgumentException('XChainBridge must be an array');
        }

        if (isset($data['lockingChainDoor']) === false) {
            throw new \InvalidArgumentException('XChainBridge must have a lockingChainDoor');
        }

        if (isset($data['lockingChainDoorIssue']) === false) {
            throw new \InvalidArgumentException('XChainBridge must have a lockingChainDoorIssue');
        }

        if (isset($data['issuingChainDoor']) === false) {
            throw new \InvalidArgumentException('XChainBridge must have an issuingChainDoor');
        }

        if (isset($data['issuingChainAssetType']) === false) {
            throw new \InvalidArgumentException('XChainBridge must have an issuingChainAssetType');
        }

        return new static(
            AccountID::fromJson($data['lockingChainDoor']),
            STIssue::fromJson($data['lockingChainDoorIssue']),
            AccountID::fromJson($data['issuingChainDoor']),
            STIssue::fromJson($data['issuingChainAssetType']),
        );
    }
}
