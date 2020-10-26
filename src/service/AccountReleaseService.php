<?php

namespace gold\GoldPortSecondService;

use gold\GoldPortSecondClient\Application;
use gold\GoldPortSecondClient\Base\Exceptions\ClientError;

/**
 * 核放单.
 */
class AccountReleaseService
{
    /**
     * @var AccountRelease
     */
    private $_accountRelease;

    public function __construct(Application $app)
    {
        $this->_accountRelease = $app['account_release'];
    }

    /**
     * 核放单报文.
     *
     * @throws ClientError
     * @throws \Exception
     */
    public function getAccountReleaseXml(array $declareConfig = [], array $declareParams = [])
    {
        if (empty($declareConfig) || empty($declareParams)) {
            throw new ClientError('参数缺失', 1000001);
        }

        return $this->_accountRelease->getAccountReleaseXml($declareConfig, $declareParams);
    }
}
