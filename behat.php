<?php declare(strict_types=1);

use Behat\Config\Config;
use Behat\Config\Extension;
use Behat\Config\Filter\TagFilter;
use Behat\Config\Profile;
use Tools\Behat\Extension\Container\ContainerExtension;

return new Config()
    ->import(__DIR__ . '/tools/behat/config/suites.php')
    ->withProfile(
        new Profile('default')
            ->withExtension(
                new Extension(ContainerExtension::class, [
                    'bootstrap' => 'tools/behat/config/bootstrap.php',
                ])
            )
            ->withFilter(new TagFilter('~@todo'))
    )
;