<?php

namespace gold\GoldPortSecondClient;

use gold\GoldPortSecondClient\Base\Config;
use Pimple\Container;

/**
 * Class Application.
 */
class Application extends Container
{
    /**
     * @var array
     */
    protected $providers = [
        Base\ServiceProvider::class,

        GoldMessage\DeclareRecord\ServiceProvider::class,
        GoldMessage\AcrossBill\ServiceProvider::class,
        GoldMessage\AccountRelease\ServiceProvider::class,
        GoldMessage\NuclearNote\ServiceProvider::class,
    ];

    /**
     * Application constructor.
     */
    public function __construct(array $config = [])
    {
        parent::__construct();

        $this['config'] = function () use ($config) {
            return new Config($config);
        };

        $this->registerProviders();
    }

    /**
     * @param $id
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Register providers.
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }
}
