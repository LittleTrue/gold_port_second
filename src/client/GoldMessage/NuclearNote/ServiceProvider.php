<?php

namespace gold\GoldPortSecondClient\GoldMessage\NuclearNote;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['nuclear_note'] = function ($app) {
            return new Client($app);
        };
    }
}
