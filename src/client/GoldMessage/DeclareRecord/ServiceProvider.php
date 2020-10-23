<?php

namespace gold\GoldPortSecondClient\GoldMessage\DeclareRecord;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['declare_record'] = function ($app) {
            return new Client($app);
        };
    }
}
