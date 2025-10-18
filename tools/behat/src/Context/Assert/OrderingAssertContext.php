<?php declare(strict_types=1);

namespace Tools\Behat\Context\Assert;

use Behat\Behat\Context\Context;
use Behat\Step\Then;
use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Webmozart\Assert\Assert;

class OrderingAssertContext implements Context
{
    #[Then('/^I should see (\d+) (?:item|items) in (the cart)$/')]
    public function iShouldSeeItemsInTheCart(int $numberOfItems, OrderContract $cart): void
    {
        $totalQuantity = $cart->items->reduce(
            fn(int $total, OrderItemContract $item) => $total + $item->quantity,
            0,
        );

        Assert::same($totalQuantity, $numberOfItems, 'The total quantity of items in the cart does not match the expected value.');
    }
}