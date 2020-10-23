<?php

namespace gold\GoldPortSecondService;

use gold\GoldPortSecondClient\Application;

/**
 * 申报单备案.
 */
class DeclareRecordService
{
    /**
     * @var DeclareRecord
     */
    private $_declareRecord;

    public function __construct(Application $app)
    {
        $this->_declareRecord = $app['declare_record'];
    }

    /**
     * 申报单备案.
     *
     * @throws ClientError
     * @throws \Exception
     */
    public function getDeclareRecordXml(array $declareConfig = [], array $declareParams = [])
    {
        // if (empty($declareConfig) || empty($declareParams)) {
        //     throw new ClientError('参数缺失', 1000001);
        // }

        return $this->_declareRecord->getDeclareRecordXml($declareConfig, $declareParams);
    }
}
