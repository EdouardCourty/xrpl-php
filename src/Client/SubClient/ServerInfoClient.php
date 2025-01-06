<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Client\JsonRpcClient;
use XRPL\Model\ServerInfo\Fee;
use XRPL\Model\ServerInfo\Manifest;
use XRPL\Model\ServerInfo\ServerDefinitions;
use XRPL\Model\ServerInfo\ServerState;
use XRPL\Model\ServerInfo\VersionResults;
use XRPL\Service\Serializer;

readonly class ServerInfoClient
{
    public function __construct(
        private Serializer $serializer,
        private JsonRpcClient $jsonRpcClient,
    ) {
    }

    public function getFee(): Fee
    {
        $response = $this->jsonRpcClient->getResult('fee');

        return $this->serializer->deserialize(json_encode($response), Fee::class, 'json');
    }

    public function getManifest(string $publicKey): Manifest
    {
        $response = $this->jsonRpcClient->getResult('manifest', [
            'public_key' => $publicKey,
        ]);

        return $this->serializer->deserialize(json_encode($response), Manifest::class, 'json');
    }

    public function getServerDefinitions(): ServerDefinitions
    {
        $response = $this->jsonRpcClient->getResult('server_definitions');

        return $this->serializer->deserialize(json_encode($response), ServerDefinitions::class, 'json');
    }

    public function getServerState(string $ledgerIndex = 'current'): ServerState
    {
        $response = $this->jsonRpcClient->getResult('server_state', [
            'ledger_index' => $ledgerIndex,
        ]);

        return $this->serializer->deserialize(json_encode($response), ServerState::class, 'json');
    }

    public function getVersion(): VersionResults
    {
        $response = $this->jsonRpcClient->getResult('version');

        return $this->serializer->deserialize(json_encode($response), VersionResults::class, 'json');
    }
}
