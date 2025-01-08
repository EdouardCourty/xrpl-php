<?php

namespace XRPL\Client\SubClient;

use XRPL\Exception\NFTNotFoundException;
use XRPL\Model\Payment\AggregatePrice;
use XRPL\Model\Payment\AMMInfo;
use XRPL\Model\Payment\AuthorizedDeposit;
use XRPL\Model\Payment\BookChanges;
use XRPL\Model\Payment\BookOffers;
use XRPL\Model\Payment\NFTBuyOffers;
use XRPL\Model\Payment\NFTSellOffers;

readonly class PaymentClient extends AbstractClient
{
    public function getAMMInfo(
        ?string $ammAccount = null,
        ?array $asset = null,
        ?array $asset2 = null,
    ): AMMInfo {
        if ($ammAccount === null && ($asset === null && $asset2 === null)) {
            throw new \InvalidArgumentException('You must provide either an AMM account or a pair of assets');
        }

        $params = [
            'amm_account' => $ammAccount,
            'asset' => $asset,
            'asset2' => $asset2,
        ];

        $response = $this->jsonRpcClient->getResult('amm_info', $params);

        return $this->serializer->deserialize(json_encode($response), AMMInfo::class, 'json');
    }

    public function getBookChanges(
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
    ): BookChanges {
        $params = [
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
        ];

        $response = $this->jsonRpcClient->getResult('book_changes', $params);

        return $this->serializer->deserialize(json_encode($response), BookChanges::class, 'json');
    }

    /**
     * @param array{currency: string, issuer: string}|string $takerGets
     * @param array{currency: string, issuer: string}|string $takerPays
     */
    public function getBookOffers(
        array|string $takerGets,
        array|string $takerPays,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?int $limit = null,
        ?string $taker = null,
    ): BookOffers {
        $params = [
            'taker_gets' => $takerGets,
            'taker_pays' => $takerPays,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'limit' => $limit,
            'taker' => $taker,
        ];

        $response = $this->jsonRpcClient->getResult('book_offers', $params);

        return $this->serializer->deserialize(json_encode($response), BookOffers::class, 'json');
    }

    public function isDepositAuthorized(
        string $sourceAccount,
        string $destinationAccount,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
    ): AuthorizedDeposit {
        $params = [
            'source_account' => $sourceAccount,
            'destination_account' => $destinationAccount,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
        ];

        $response = $this->jsonRpcClient->getResult('deposit_authorized', $params);

        return $this->serializer->deserialize(json_encode($response), AuthorizedDeposit::class, 'json');
    }

    public function getAggregatePrice(
        string $baseAsset,
        string $quoteAsset,
        ?int $trim = null,
        ?int $trimThreshold = null,
        array $oracles = [],
    ): AggregatePrice {
        if (empty($oracles)) {
            throw new \InvalidArgumentException('You must provide at least one oracle');
        }

        $params = [
            'base_asset' => $baseAsset,
            'quote_asset' => $quoteAsset,
            'trim' => $trim,
            'trim_threshold' => $trimThreshold,
            'oracles' => $oracles,
        ];

        $response = $this->jsonRpcClient->getResult('get_aggregate_price', $params);

        return $this->serializer->deserialize(json_encode($response), AggregatePrice::class, 'json');
    }

    /**
     * @throws NFTNotFoundException
     */
    public function getNFTBuyOffers(
        string $nftId,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?int $limit = null,
        mixed $marker = null,
    ): NFTBuyOffers {
        $params = [
            'nft_id' => $nftId,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('nft_buy_offers', $params);

        $nftBuyOffers = $this->serializer->deserialize(json_encode($response), NFTBuyOffers::class, 'json');

        if($nftBuyOffers->nftId === null) {
            throw NFTNotFoundException::fromIdentifier($nftId);
        }

        return $nftBuyOffers;
    }

    public function getNFTSellOffers(
        string $nftId,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?int $limit = null,
        mixed $marker = null,
    ): NFTSellOffers {
        $params = [
            'nft_id' => $nftId,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('nft_sell_offers', $params);

        $nftSellOffers = $this->serializer->deserialize(json_encode($response), NFTSellOffers::class, 'json');

        if($nftSellOffers->nftId === null) {
            throw NFTNotFoundException::fromIdentifier($nftId);
        }

        return $nftSellOffers;
    }
}
