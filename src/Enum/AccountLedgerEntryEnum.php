<?php

declare(strict_types=1);

namespace XRPL\Enum;

enum AccountLedgerEntryEnum: string
{
    case BRIDGE = 'bridge';
    case CHECK = 'check';
    case DEPOSIT_PREAUTH = 'deposit_preauth';
    case ESCROW = 'escrow';
    case NFT_OFFER = 'nft_offer';
    case NFT_PAGE = 'nft_page';
    case OFFER = 'offer';
    case PAYMENT_CHANNEL = 'payment_channel';
    case SIGNER_LIST = 'signer_list';
    case STATE = 'state';
    case TICKET = 'ticket';
}
