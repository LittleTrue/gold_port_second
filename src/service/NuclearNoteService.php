<?php

namespace gold\GoldPortSecondService;

use gold\GoldPortSecondClient\Application;
use gold\GoldPortSecondClient\Base\Exceptions\ClientError;

/**
 * 核注清单.
 */
class NuclearNoteService
{
    /**
     * @var NuclearNote
     */
    private $_nuclearNote;

    public function __construct(Application $app)
    {
        $this->_nuclearNote = $app['nuclear_note'];
    }

    /**
     * 核注清单.
     *
     * @throws ClientError
     * @throws \Exception
     */
    public function getNuclearNoteXml(array $declareConfig = [], array $declareParams = [])
    {
        if (empty($declareConfig) || empty($declareParams)) {
            throw new ClientError('参数缺失', 1000001);
        }

        return $this->_nuclearNote->getNuclearNoteXml($declareConfig, $declareParams);
    }
}
