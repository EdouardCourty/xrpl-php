<?php

declare(strict_types=1);

namespace XRPL\Service\Signature;

use XRPL\ValueObject\TransactionFieldDefinition;

/**
 * @author Edouard Courty
 */
class ServerDefinitions
{
    private const string FILE_PATH = __DIR__ . '/../../../data/XRPL_Definitions.json';

    private static ?self $instance = null;

    /**
     * @var array{
     *      FIELDS: array<array{string, array{isSerialized: bool, isSigningField: bool, isVLEncoded: bool, nth: int, type: string}}>,
     *      LEDGER_ENTRY_TYPES: array<string, int>,
     *      TRANSACTION_RESULTS: array<string, int>,
     *      TRANSACTION_TYPES: array<string, int>,
     *      TYPES: array<string, int>,
     *  } $rawData
     */
    private array $rawData;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $fileContent = file_get_contents(self::FILE_PATH);

        if (false === $fileContent) {
            throw new \LogicException('Unable to read definitions file');
        }

        $this->rawData = json_decode($fileContent, true);
    }

    public function getFieldDefinition(string $name): TransactionFieldDefinition
    {
        $fieldInfo = $this->getFieldInfo($name);

        return new TransactionFieldDefinition(
            $name,
            $fieldInfo['nth'],
            $fieldInfo['isVLEncoded'],
            $fieldInfo['isSerialized'],
            $fieldInfo['isSigningField'],
            $fieldInfo['type'],
            $this->getTypeCode($fieldInfo['type']),
        );
    }

    /**
     * @return array{isSerialized: bool, isSigningField: bool, isVLEncoded: bool, nth: int, type: string}
     */
    private function getFieldInfo(string $fieldName): array
    {
        foreach ($this->rawData['FIELDS'] as $field) {
            if ($field[0] === $fieldName) {
                return $field[1];
            }
        }

        throw new \LogicException('Non-existent field');
    }

    private function getTypeCode(string $type): int
    {
        return (int) $this->rawData['TYPES'][$type];
    }

    public function getTransactionType(string $transactionTypeString): int
    {
        if (false === isset($this->rawData['TRANSACTION_TYPES'][$transactionTypeString])) {
            throw new \InvalidArgumentException('Invalid transaction type');
        }

        return (int) $this->rawData['TRANSACTION_TYPES'][$transactionTypeString];
    }
}
