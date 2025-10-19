<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Recode\Ecommerce\Core\Shared\Contract\PriceAdjustmentContract;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

class PriceAdjustmentMother
{
    public static function some(
        ?Price $amount = null,
        string $description = 'OMG',
        string $type = 'tax',
        bool $isNeutral = false,
    ): PriceAdjustmentContract {
        $amount = $amount ?? Price::new(150, Currency::new('PLN'));

        return new readonly class ($amount, $description, $type, $isNeutral) implements PriceAdjustmentContract {
            public function __construct(
                public Price $amount,
                public string $description,
                public string $type,
                public bool $isNeutral,
            ) {
            }
        };
    }
}
