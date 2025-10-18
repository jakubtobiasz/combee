<?php declare(strict_types=1);

use Behat\Config\Config;
use Behat\Config\Profile;
use Behat\Config\Suite;

$profile = new Profile('default');

foreach (glob(__DIR__ . '/suites/*.php') as $suiteFile) {
    $suite = require $suiteFile;

    if (!$suite instanceof Suite) {
        throw new \RuntimeException(sprintf('Suite file "%s" must return an instance of "%s".', $suiteFile, Suite::class));
    }

    $profile = $profile->withSuite(require $suiteFile);
}

return new Config()->withProfile($profile);
