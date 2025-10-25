<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Processor;

use Recode\Ecommerce\Core\Ordering\Contract\Exception\ProductDataCannotBeProvidedException;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Processor\CartProcessorContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\PriceProviderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\Contract\Collection;

final readonly class RefreshUnitItemPricesCartProcessor implements CartProcessorContract
{
    public const string SKIP_KEY = 'skip_item_price_refresh';

    public function __construct(
        private PriceProviderContract $priceProvider,
        private ProductDataProviderContract $productDataProvider,
    ) {
    }

    public function process(OrderContract $cart, Collection $context = new ArrayCollection()): void
    {
        if ($context->containsKey(self::SKIP_KEY) && $context->get(self::SKIP_KEY) === true) {
            return;
        }

        foreach ($cart->items as $item) {
            $product = $this->productDataProvider->getProductData($item->productSku);
            ProductDataCannotBeProvidedException::throwIfNull($product);

            $item->unitPrice = $this->priceProvider->provideFor($product);
        }
    }
}
