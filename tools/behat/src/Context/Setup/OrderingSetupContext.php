<?php declare(strict_types=1);

namespace Tools\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Combee\Core\Ordering\Contract\Storage\CartStorageContract;
use Tests\Helper\MotherObject\OrderMother;
use Tools\Behat\Service\SharedStorageContract;

class OrderingSetupContext implements Context
{
    public function __construct(
        private CartStorageContract $cartStorage,
        private SharedStorageContract $sharedStorage,
    ) {
    }

    #[Given('I have already picked up a cart')]
    public function iHaveAlreadyPickedUpCart(): void
    {
        $cart = OrderMother::some();

        $this->cartStorage->store($cart);
        $this->sharedStorage->set('cart', $cart);
    }
}