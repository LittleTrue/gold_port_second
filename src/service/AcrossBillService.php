<?php

namespace gold\GoldPortSecondService;

use gold\GoldPortSecondClient\Application;
use gold\GoldPortSecondClient\Base\Exceptions\ClientError;

/**
 * 出入库.
 */
class AcrossBillService
{
    /**
     * @var AcrossBill
     */
    private $_acrossBill;

    public function __construct(Application $app)
    {
        $this->_acrossBill = $app['across_bill'];
    }

    /**
     * 出入库报文.
     *
     * @throws ClientError
     * @throws \Exception
     */
    public function generateXml(array $declareConfig = [], array $declareParams = [])
    {
        if (empty($declareConfig) || empty($declareParams)) {
            throw new ClientError('参数缺失', 1000001);
        }

        return $this->_acrossBill->getAcrossBillXml($declareConfig, $declareParams);
    }
}
