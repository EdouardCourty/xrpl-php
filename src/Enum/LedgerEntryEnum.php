<?php

declare(strict_types=1);

namespace XRPL\Enum;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
enum LedgerEntryEnum: string
{
    case ACCOUNT = 'account';
    case AMENDEMENTS = 'amendments';
    case AMM = 'amm';
    case CHECK = 'check';
    case DEPOSIT_PREAUTH = 'deposit_preauth';
    case DIRECTORY = 'directory';
    case ESCROW = 'escrow';
    case FEE = 'fee';
    case HASHES = 'hashes';
    case NFT_OFFER = 'nft_offer';
    case OFFER = 'offer';
    case PAYMENT_CHANNEL = 'payment_channel';
    case SIGNER_LIST = 'signer_list';
    case STATE = 'state';
    case TICKET = 'ticket';
}
