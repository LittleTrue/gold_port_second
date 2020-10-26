<?php

namespace gold\GoldPortSecondClient\GoldMessage\AcrossBill;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['across_bill'] = function ($app) {
            return new Client($app);
        };
    }
}
