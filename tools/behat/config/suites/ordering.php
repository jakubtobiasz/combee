<?php declare(strict_types=1);

use Behat\Config\Filter\TagFilter;
use Behat\Config\Suite;
use Tools\Behat\Context\Action\ProductCatalogActionContext;
use Tools\Behat\Context\Assert\OrderingAssertContext;
use Tools\Behat\Context\Setup\OrderingSetupContext;
use Tools\Behat\Context\Setup\ProductCatalogSetupContext;
use Tools\Behat\Transform\PriceTransformContext;
use Tools\Behat\Transform\ProductCatalogTransformContext;
use Tools\Behat\Transform\SharedStorageTransformContext;

return new Suite('ordering')
    ->withContexts(
        // Transformers
        PriceTransformContext::class,
        ProductCatalogTransformContext::class,
        SharedStorageTransformContext::class,

        // Setup contexts
        OrderingSetupContext::class,
        ProductCatalogSetupContext::class,

        // Action contexts
        ProductCatalogActionContext::class,

        // Assert contexts
        OrderingAssertContext::class,
    )
    ->withFilter(new TagFilter('@ordering&&@application'))
;
