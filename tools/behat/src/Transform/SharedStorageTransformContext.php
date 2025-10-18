<?php declare(strict_types=1);

namespace Tools\Behat\Transform;

use Behat\Behat\Context\Context;
use Behat\Transformation\Transform;
use Tools\Behat\Service\SharedStorageContract;

class SharedStorageTransformContext implements Context
{
    public function __construct(
        private readonly SharedStorageContract $sharedStorage,
    ) {
    }

    #[Transform('/^(?:this|that|the) ([^"]+)$/')]
    public function transformProductSku(string $storageKey): mixed
    {
        return $this->sharedStorage->get($storageKey);
    }
}