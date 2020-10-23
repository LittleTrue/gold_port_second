<?php

namespace gold\GoldPortSecondClient\CebMessage\ArrivalExport;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['arrival_export'] = function ($app) {
            return new Client($app);
        };
    }
}
