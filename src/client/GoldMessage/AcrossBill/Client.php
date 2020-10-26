<?php

namespace gold\GoldPortSecondClient\GoldMessage\AcrossBill;

use gold\GoldPortSecondClient\Application;
use gold\GoldPortSecondClient\Base\BaseClient;
use gold\GoldPortSecondClient\Base\Exceptions\ClientError;
use gold\GoldPortSecondClient\Base\GoldMessageBuild;

/**
 * 客户端.
 */
class Client extends BaseClient
{
    use GoldMessageBuild;

    /**
     * @var Application
     */
    protected $credentialValidate;

    //报文发送时间
    private $sendTime;

    private $message_type = 'SAS111';

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->credentialValidate = $app['credential'];
    }

    /**
     * 出入库报文.
     */
    public function getAcrossBillXml(array $declareConfig, array $declareParams)
    {
        //校验数据
        $rule = [
            'business_id'    => 'require',
            'message_id'     => 'require',
            'file_name'      => 'require',
            'sender_id'      => 'require',
            'receiver_id'    => 'require',
            'OperCusRegCode' => 'require',
            'DelcareFlag'    => 'require',
            'Ic_Card'        => 'require',
        ];

        $this->credentialValidate->setRule($rule);

        if (!$this->credentialValidate->check($declareConfig)) {
            throw new ClientError('报文传输配置' . $this->credentialValidate->getError());
        }

        $this->checkInfo($declareParams);

        $attribute = [
            'xsi:noNamespaceSchemaLocation' => 'SAS111.xsd',
            'xmlns:xsi'                     => 'http://www.w3.org/2001/XMLSchema-instance',
        ];

        //根节点生成--父类
        $this->setRootNode($attribute);

        $head = $declareParams['appHeadType'];

        $goods = $declareParams['appGoodsType'];

        $pocketInfo = $declareParams['pocketInfo'];

        //生成签名节点
        $this->createSignedInfo($this->dom, $this->nodeLink['root_node'], $this->message_type);

        $Object = $this->dom->createElement('Object');
        $this->nodeLink['root_node']->appendchild($Object);
        $this->nodeLink['Object'] = $Object;

        $Package = $this->dom->createElement('Package');
        $this->nodeLink['Object']->appendchild($Package);
        $this->nodeLink['Package'] = $Package;

        $EnvelopInfo = $this->dom->createElement('EnvelopInfo');
        $this->nodeLink['Package']->appendchild($EnvelopInfo);

        $this->sendTime = date('YmdHis', time());

        $EnvelopInfoEle = [
            'version'      => $this->version,
            'business_id'  => $declareConfig['business_id'],
            'message_id'   => $declareConfig['message_id'],
            'file_name'    => $declareConfig['file_name'],
            'message_type' => $this->message_type,
            'sender_id'    => $declareConfig['sender_id'],
            'receiver_id'  => $declareConfig['receiver_id'],
            'send_time'    => $this->sendTime,
            'Ic_Card'      => $declareConfig['Ic_Card'],
        ];

        $this->dom = $this->createEle($EnvelopInfoEle, $this->dom, $EnvelopInfo);

        $DataInfo = $this->dom->createElement('DataInfo');
        $this->nodeLink['Package']->appendchild($DataInfo);
        $this->nodeLink['DataInfo'] = $DataInfo;

        $PocketInfo = $this->dom->createElement('PocketInfo');
        $this->nodeLink['DataInfo']->appendchild($PocketInfo);

        $this->dom = $this->createEle(['is_unstructured' => $pocketInfo['is_unstructured']], $this->dom, $PocketInfo);

        $BussinessData = $this->dom->createElement('BussinessData');
        $this->nodeLink['DataInfo']->appendchild($BussinessData);
        $this->nodeLink['BussinessData'] = $BussinessData;

        $StockMessage = $this->dom->createElement('StockMessage');
        $this->nodeLink['BussinessData']->appendchild($StockMessage);
        $this->nodeLink['StockMessage'] = $StockMessage;

        foreach ($head as $key => $value) {
            $StockHead = $this->dom->createElement('StockHead');
            $this->nodeLink['StockMessage']->appendchild($StockHead);

            $StockHeadEle = [
                'SeqNo'             => $value['SeqNo'],
                'DclTypecd'         => $value['DclTypecd'],
                'SasDclNo'          => $value['SasDclNo'],
                'AreainOriactNo'    => $value['AreainOriactNo'],
                'AreainEtpsNo'      => $value['AreainEtpsNo'],
                'AreainEtpsNm'      => $value['AreainEtpsNm'],
                'AreainEtpsSccd'    => $value['AreainEtpsSccd'],
                'MasterCuscd'       => $value['MasterCuscd'],
                'StockTypecd'       => $value['StockTypecd'],
                'BusinessTypecd'    => $value['BusinessTypecd'],
                'DclEr'             => $value['DclEr'],
                'DclEtpsNo'         => $value['DclEtpsNo'],
                'DclEtpsNm'         => $value['DclEtpsNm'],
                'DclEtpsSccd'       => $value['DclEtpsSccd'],
                'InputCode'         => $value['InputCode'],
                'InputSccd'         => $value['InputSccd'],
                'InputName'         => $value['InputName'],
                'EtpsPreentNo'      => $value['EtpsPreentNo'],
                'PackageQty'        => $value['PackageQty'],
                'GrossWt'           => $value['GrossWt'],
                'NetWt'             => $value['NetWt'],
                'PackType'          => $value['PackType'],
                'InputDate'         => $value['InputDate'],
                'MtpckEndprdTypecd' => $value['MtpckEndprdTypecd'],
            ];

            $this->dom = $this->createEle($StockHeadEle, $this->dom, $StockHead);
        }

        foreach ($goods as $key => $value) {
            $StockGoods = $this->dom->createElement('StockGoods');
            $this->nodeLink['StockMessage']->appendchild($StockGoods);

            $StockGoodsEle = [
                'SeqNo'            => $value['SeqNo'],
                'SasStockSeqno'    => $value['SasStockSeqno'],
                'SasDclSeqno'      => $value['SasDclSeqno'],
                'OriactGdsSeqno'   => $value['OriactGdsSeqno'],
                'GdsMtno'          => $value['GdsMtno'],
                'Gdecd'            => $value['Gdecd'],
                'GdsNm'            => $value['GdsNm'],
                'GdsSpcfModelDesc' => $value['GdsSpcfModelDesc'],
                'DclUnitcd'        => $value['DclUnitcd'],
                'LawfUnitcd'       => $value['LawfUnitcd'],
                'Natcd'            => $value['Natcd'],
                'DclUprcAmt'       => $value['DclUprcAmt'],
                'DclTotalAmt'      => $value['DclTotalAmt'],
                'DclCurrcd'        => $value['DclCurrcd'],
                'LawfQty'          => $value['LawfQty'],
                'WtSfVal'          => $value['WtSfVal'],
                'FstSfVal'         => $value['FstSfVal'],
                'SecdSfVal'        => $value['SecdSfVal'],
                'DclQty'           => $value['DclQty'],
                'GrossWt'          => $value['GrossWt'],
                'NetWt'            => $value['NetWt'],
                'LvyrlfModecd'     => $value['LvyrlfModecd'],
                'UcnsVerno'        => $value['UcnsVerno'],
                'RltGdsSeqno'      => $value['RltGdsSeqno'],
                'DestinationNatcd' => $value['DestinationNatcd'],
                'ModfMarcked'      => $value['ModfMarcked'],
            ];

            $this->dom = $this->createEle($StockGoodsEle, $this->dom, $StockGoods);
        }

        $OperCusRegCodeEle = [
            'OperCusRegCode' => $declareConfig['OperCusRegCode'],
        ];

        $this->createEle($OperCusRegCodeEle, $this->dom, $StockMessage);

        $DelcareFlagEle = [
            'DelcareFlag' => $declareConfig['DelcareFlag'],
        ];

        $this->createEle($DelcareFlagEle, $this->dom, $BussinessData);

        return $this->dom->saveXML();
    }

    public function checkInfo($data)
    {
        //检验申报表信息
        $appHeadType  = $data['appHeadType'];
        $appGoodsType = $data['appGoodsType'];

        $appHeadType_rules = [
            'SeqNo'             => 'require|max:10',
            'DclTypecd'         => 'require|in:1,2,3',
            'SasDclNo'          => 'require|max:64',
            'AreainOriactNo'    => 'max:64',
            'AreainEtpsNo'      => 'max:10',
            'AreainEtpsNm'      => 'max:512',
            'AreainEtpsSccd'    => 'max:18',
            'MasterCuscd'       => 'require|max:4',
            'StockTypecd'       => 'require|in:I,E',
            'BusinessTypecd'    => 'require|max:1',
            'DclEr'             => 'require|max:256',
            'DclEtpsNo'         => 'require|max:10',
            'DclEtpsNm'         => 'require|max:512',
            'DclEtpsSccd'       => 'max:18',
            'InputCode'         => 'require|max:10',
            'InputSccd'         => 'max:18',
            'InputName'         => 'require|max:255',
            'EtpsPreentNo'      => 'require|max:64',
            'PackageQty'        => 'number',
            'GrossWt'           => 'number',
            'NetWt'             => 'number',
            'PackType'          => 'max:256',
            'InputDate'         => 'require|max:10',
            'MtpckEndprdTypecd' => 'max:4',
        ];

        $appGoodsType_rules = [
            'SeqNo'            => 'max:18',
            'SasStockSeqno'    => 'require|max:19',
            'SasDclSeqno'      => 'require|max:19',
            'OriactGdsSeqno'   => 'max:19',
            'GdsMtno'          => 'require|max:32',
            'Gdecd'            => 'require|max:10',
            'GdsNm'            => 'require|max:512',
            'GdsSpcfModelDesc' => 'require|max:512',
            'DclUnitcd'        => 'require|max:3',
            'LawfUnitcd'       => 'require|max:3',
            'Natcd'            => 'require|max:3',
            'DclUprcAmt'       => 'require|max:25',
            'DclTotalAmt'      => 'require|max:25',
            'DclCurrcd'        => 'require|max:3',
            'LawfQty'          => 'require|max:19',
            'WtSfVal'          => 'max:19',
            'FstSfVal'         => 'max:19',
            'SecdSfVal'        => 'max:19',
            'DclQty'           => 'require|max:19',
            'GrossWt'          => 'max:19',
            'NetWt'            => 'max:19',
            'LvyrlfModecd'     => 'require|max:6',
            'UcnsVerno'        => 'max:8',
            'RltGdsSeqno'      => 'max:19',
            'DestinationNatcd' => 'require|max:3',
            'ModfMarcked'      => 'max:3',
        ];
        $this->credentialValidate->setRule($appHeadType_rules);

        foreach ($appHeadType as $key => $value) {
            if (!$this->credentialValidate->check($value)) {
                throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
            }
        }

        $this->credentialValidate->setRule($appGoodsType_rules);

        foreach ($appGoodsType as $key => $value) {
            if (!$this->credentialValidate->check($value)) {
                throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
            }
        }

        return true;
    }
}
