<?php declare(strict_types=1);

namespace Tools\Behat\Transform;

use Behat\Behat\Context\Context;
use Behat\Transformation\Transform;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

class PriceTransformContext implements Context
{
    #[Transform('/^(\d+[.,]\d{2})\s+([A-Z]{3})$/')]
    public function transformPrice(int $amount, string $currencyCode): Price
    {
        return new Price($amount, Currency::new($currencyCode));
    }
}