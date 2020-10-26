<?php

namespace gold\GoldPortSecondClient\GoldMessage\AccountRelease;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['account_release'] = function ($app) {
            return new Client($app);
        };
    }
}
