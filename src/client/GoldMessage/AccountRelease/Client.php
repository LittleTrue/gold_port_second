<?php

namespace gold\GoldPortSecondClient\GoldMessage\AccountRelease;

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

    private $message_type = 'SAS121';

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->credentialValidate = $app['credential'];
    }

    /**
     * 核放单报文.
     */
    public function getAccountReleaseXml($declareConfig, $declareParams)
    {
        //校验数据
        $rule = [
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
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        ];

        //根节点生成--父类
        $this->setRootNode($attribute);

        $head = $declareParams['appHeadType'];

        $passport = $declareParams['passport'];

        $pocketInfo = $declareParams['pocketInfo'];

        //生成签名节点
        $this->createSignedInfo($this->dom, $this->nodeLink['root_node'], $this->message_type);

        $Object = $this->dom->createElement('Object');
        $Object->setAttribute('Id', 'String');
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

        $PocketInfoEle = [
            'pocket_id'        => $pocketInfo['pocket_id'],
            'total_pocket_qty' => $pocketInfo['total_pocket_qty'],
            'cur_pocket_no'    => $pocketInfo['cur_pocket_no'],
            'is_unstructured'  => $pocketInfo['is_unstructured'],
        ];

        $this->dom = $this->createEle($PocketInfoEle, $this->dom, $PocketInfo);

        $BussinessData = $this->dom->createElement('BussinessData');
        $this->nodeLink['DataInfo']->appendchild($BussinessData);
        $this->nodeLink['BussinessData'] = $BussinessData;

        $PassPortMessage = $this->dom->createElement('PassPortMessage');
        $this->nodeLink['BussinessData']->appendchild($PassPortMessage);
        $this->nodeLink['PassPortMessage'] = $PassPortMessage;

        foreach ($head as $key => $value) {
            $PassportHead = $this->dom->createElement('PassportHead');
            $this->nodeLink['PassPortMessage']->appendchild($PassportHead);

            $PassportHeadEle = [
                'SeqNo'          => $value['SeqNo'],
                'PassportNo'     => $value['PassportNo'],
                'PassportTypecd' => $value['PassportTypecd'],
                'MasterCuscd'    => $value['MasterCuscd'],
                'DclTypecd'      => $value['DclTypecd'],
                'IoTypecd'       => $value['IoTypecd'],
                'BindTypecd'     => $value['BindTypecd'],
                'RltTbTypecd'    => $value['RltTbTypecd'],
                'RltNo'          => $value['RltNo'],
                'AreainOriactNo' => $value['AreainOriactNo'],
                'AreainEtpsno'   => $value['AreainEtpsno'],
                'AreainEtpsNm'   => $value['AreainEtpsNm'],
                'AreainEtpsSccd' => $value['AreainEtpsSccd'],
                'VehicleNo'      => $value['VehicleNo'],
                'VehicleIcNo'    => $value['VehicleIcNo'],
                'ContainerNo'    => $value['ContainerNo'],
                'VehicleWt'      => $value['VehicleWt'],
                'VehicleFrameNo' => $value['VehicleFrameNo'],
                'VehicleFrameWt' => $value['VehicleFrameWt'],
                'ContainerType'  => $value['ContainerType'],
                'ContainerWt'    => $value['ContainerWt'],
                'TotalWt'        => $value['TotalWt'],
                'TotalGrossWt'   => $value['TotalGrossWt'],
                'TotalNetWt'     => $value['TotalNetWt'],
                'DclErConc'      => $value['DclErConc'],
                'DclTime'        => $value['DclTime'],
                'DclEtpsno'      => $value['DclEtpsno'],
                'DclEtpsNm'      => $value['DclEtpsNm'],
                'DclEtpsSccd'    => $value['DclEtpsSccd'],
                'InputCode'      => $value['InputCode'],
                'InputSccd'      => $value['InputSccd'],
                'InputName'      => $value['InputName'],
                'EtpsPreentNo'   => $value['EtpsPreentNo'],
                'Rmk'            => $value['Rmk'],
                'Col1'           => $value['Col1'],
            ];

            $this->dom = $this->createEle($PassportHeadEle, $this->dom, $PassportHead);
        }

        foreach ($passport as $key => $value) {
            $PassportAcmp = $this->dom->createElement('PassportAcmp');
            $this->nodeLink['PassPortMessage']->appendchild($PassportAcmp);

            $PassportAcmpEle = [
                'SeqNo'         => $value['SeqNo'],
                'PassPortNo'    => $value['PassPortNo'],
                'RtlBillTypecd' => $value['RtlBillTypecd'],
                'RtlBillNo'     => $value['RtlBillNo'],
            ];

            $this->dom = $this->createEle($PassportAcmpEle, $this->dom, $PassportAcmp);
        }

        $OperCusRegCodeEle = [
            'OperCusRegCode' => $declareConfig['OperCusRegCode'],
        ];

        $this->createEle($OperCusRegCodeEle, $this->dom, $PassPortMessage);

        $DelcareFlagEle = [
            'DelcareFlag' => $declareConfig['DelcareFlag'],
        ];

        $this->createEle($DelcareFlagEle, $this->dom, $BussinessData);

        return $this->dom->saveXML();
    }

    public function checkInfo($data)
    {
        //检验申报表信息
        $appHeadType = $data['appHeadType'];
        $passport    = $data['passport'];

        $appHeadType_rules = [
            'SeqNo'          => 'max:18',
            'PassportNo'     => 'max:64',
            'PassportTypecd' => 'require|in:1,2,3,4,5,6',
            'MasterCuscd'    => 'require|max:4',
            'DclTypecd'      => 'require|in:1,3',
            'IoTypecd'       => 'require|in:I,E',
            'BindTypecd'     => 'in:1,2,3',
            'RltTbTypecd'    => 'in:1,2,3',
            'RltNo'          => 'max:512',
            'AreainOriactNo' => 'max:64',
            'AreainEtpsno'   => 'require|max:10',
            'AreainEtpsNm'   => 'require|max:512',
            'AreainEtpsSccd' => 'max:18',
            'VehicleNo'      => 'max:128',
            'VehicleIcNo'    => 'max:128',
            'ContainerNo'    => 'max:128',
            'VehicleWt'      => 'require|max:19',
            'VehicleFrameNo' => 'max:256',
            'VehicleFrameWt' => 'max:256',
            'ContainerType'  => 'require|max:256',
            'ContainerWt'    => 'require|max:19',
            'TotalWt'        => 'require|max:19',
            'TotalGrossWt'   => 'require|max:19',
            'TotalNetWt'     => 'require|max:19',
            'DclErConc'      => 'require|max:512',
            'DclEtpsno'      => 'require|max:10',
            'DclEtpsNm'      => 'require|max:512',
            'DclEtpsSccd'    => 'max:18',
            'InputCode'      => 'require|max:10',
            'InputSccd'      => 'max:18',
            'InputName'      => 'require|max:255',
            'EtpsPreentNo'   => 'require|max:64',
            'Rmk'            => 'max:512',
            'Col1'           => 'in:1,2',
        ];

        $passport_rules = [
            'SeqNo'         => 'max:18',
            'PassPortNo'    => 'max:64',
            'RtlBillTypecd' => 'require|in:1,2,3',
            'RtlBillNo'     => 'require|max:64',
        ];
        $this->credentialValidate->setRule($appHeadType_rules);

        foreach ($appHeadType as $key => $value) {
            if (!$this->credentialValidate->check($value)) {
                throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
            }
        }

        $this->credentialValidate->setRule($passport_rules);

        foreach ($passport as $key => $value) {
            if (!$this->credentialValidate->check($value)) {
                throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
            }
        }

        return true;
    }
}
