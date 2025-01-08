<?php

declare(strict_types=1);

namespace XRPL\Model\Payment\Nested;

class BookUpdate
{
    public string $currencyA;
    public string $currencyB;
    public string|int $volumeA;
    public string|int $volumeB;
    public string|int $high;
    public string|int $low;
    public string|int $open;
    public string|int $close;
}
