<?php

namespace gold\GoldPortSecondClient\GoldMessage\NuclearNote;

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

    private $message_type = 'INV101';

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->credentialValidate = $app['credential'];
    }

    /**
     * 核注清单.
     */
    public function getNuclearNoteXml($declareConfig, $declareParams)
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
            'SysId'          => 'require',
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

        $head = $declareParams['HeadType'];

        $list = $declareParams['list'];

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

        $InvtMessage = $this->dom->createElement('InvtMessage');
        $this->nodeLink['BussinessData']->appendchild($InvtMessage);
        $this->nodeLink['InvtMessage'] = $InvtMessage;

        foreach ($head as $key => $value) {
            $InvtHeadType = $this->dom->createElement('InvtHeadType');
            $this->nodeLink['InvtMessage']->appendchild($InvtHeadType);

            $InvtHeadTypeEle = [
                'SeqNo'                  => $value['SeqNo'],
                'BondInvtNo'             => $value['BondInvtNo'],
                'ChgTmsCnt'              => $value['ChgTmsCnt'],
                'PutrecNo'               => $value['PutrecNo'],
                'InvtType'               => $value['InvtType'],
                'EtpsInnerInvtNo'        => $value['EtpsInnerInvtNo'],
                'BizopEtpsno'            => $value['BizopEtpsno'],
                'BizopEtpsSccd'          => $value['BizopEtpsSccd'],
                'BizopEtpsNm'            => $value['BizopEtpsNm'],
                'RcvgdEtpsno'            => $value['RcvgdEtpsno'],
                'RvsngdEtpsSccd'         => $value['RvsngdEtpsSccd'],
                'RcvgdEtpsNm'            => $value['RcvgdEtpsNm'],
                'DclEtpsno'              => $value['DclEtpsno'],
                'DclEtpsSccd'            => $value['DclEtpsSccd'],
                'DclEtpsNm'              => $value['DclEtpsNm'],
                'InputCode'              => $value['InputCode'],
                'InputCreditCode'        => $value['InputCreditCode'],
                'InputName'              => $value['InputName'],
                'InputTime'              => $value['InputTime'],
                'RltInvtNo'              => $value['RltInvtNo'],
                'RltPutrecNo'            => $value['RltPutrecNo'],
                'CorrEntryDclEtpsNo'     => $value['CorrEntryDclEtpsNo'],
                'CorrEntryDclEtpsSccd'   => $value['CorrEntryDclEtpsSccd'],
                'CorrEntryDclEtpsNm'     => $value['CorrEntryDclEtpsNm'],
                'RltEntryBizopEtpsno'    => $value['RltEntryBizopEtpsno'],
                'RltEntryBizopEtpsSccd'  => $value['RltEntryBizopEtpsSccd'],
                'RltEntryBizopEtpsNm'    => $value['RltEntryBizopEtpsNm'],
                'RltEntryRcvgdEtpsno'    => $value['RltEntryRcvgdEtpsno'],
                'RltEntryRvsngdEtpsSccd' => $value['RltEntryRvsngdEtpsSccd'],
                'RltEntryRcvgdEtpsNm'    => $value['RltEntryRcvgdEtpsNm'],
                'RltEntryDclEtpsno'      => $value['RltEntryDclEtpsno'],
                'RltEntryDclEtpsSccd'    => $value['RltEntryDclEtpsSccd'],
                'RltEntryDclEtpsNm'      => $value['RltEntryDclEtpsNm'],
                'ImpexpPortcd'           => $value['ImpexpPortcd'],
                'DclPlcCuscd'            => $value['DclPlcCuscd'],
                'ImpexpMarkcd'           => $value['ImpexpMarkcd'],
                'MtpckEndprdMarkcd'      => $value['MtpckEndprdMarkcd'],
                'SupvModecd'             => $value['SupvModecd'],
                'TrspModecd'             => $value['TrspModecd'],
                'ApplyNo'                => $value['ApplyNo'],
                'ListType'               => $value['ListType'],
                'DclcusFlag'             => $value['DclcusFlag'],
                'DclcusTypecd'           => $value['DclcusTypecd'],
                'IcCardNo'               => $value['IcCardNo'],
                'DecType'                => $value['DecType'],
                'Rmk'                    => $value['Rmk'],
                'StshipTrsarvNatcd'      => $value['StshipTrsarvNatcd'],
                'EntryNo'                => $value['EntryNo'],
                'RltEntryNo'             => $value['RltEntryNo'],
                'DclTypecd'              => $value['DclTypecd'],
                'InvtDclTime'            => $value['InvtDclTime'],
                'EntryDclTime'           => $value['EntryDclTime'],
                'VrfdedMarkcd'           => $value['VrfdedMarkcd'],
                'InvtIochkptStucd'       => $value['InvtIochkptStucd'],
                'PrevdTime'              => $value['PrevdTime'],
                'FormalVrfdedTime'       => $value['FormalVrfdedTime'],
                'EntryStucd'             => $value['EntryStucd'],
                'PassportUsedTypeCd'     => $value['PassportUsedTypeCd'],
                'NeedEntryModified'      => $value['NeedEntryModified'],
                'LevyBlAmt'              => $value['LevyBlAmt'],
                'GenDecFlag'             => $value['GenDecFlag'],
            ];

            $this->dom = $this->createEle($InvtHeadTypeEle, $this->dom, $InvtHeadType);
        }

        foreach ($list as $key => $value) {
            $InvtListType = $this->dom->createElement('InvtListType');
            $this->nodeLink['InvtMessage']->appendchild($InvtListType);

            $InvtListTypeEle = [
                'SeqNo'            => $value['SeqNo'],
                'GdsSeqno'         => $value['GdsSeqno'],
                'PutrecSeqno'      => $value['PutrecSeqno'],
                'GdsMtno'          => $value['GdsMtno'],
                'Gdecd'            => $value['Gdecd'],
                'GdsNm'            => $value['GdsNm'],
                'GdsSpcfModelDesc' => $value['GdsSpcfModelDesc'],
                'DclUnitcd'        => $value['DclUnitcd'],
                'LawfUnitcd'       => $value['LawfUnitcd'],
                'SecdLawfUnitcd'   => $value['SecdLawfUnitcd'],
                'Natcd'            => $value['Natcd'],
                'DclUprcAmt'       => $value['DclUprcAmt'],
                'DclTotalAmt'      => $value['DclTotalAmt'],
                'UsdStatTotalAmt'  => $value['UsdStatTotalAmt'],
                'DclCurrcd'        => $value['DclCurrcd'],
                'LawfQty'          => $value['LawfQty'],
                'SecdLawfQty'      => $value['SecdLawfQty'],
                'WtSfVal'          => $value['WtSfVal'],
                'FstSfVal'         => $value['FstSfVal'],
                'SecdSfVal'        => $value['SecdSfVal'],
                'DclQt'            => $value['DclQt'],
                'GrossWt'          => $value['GrossWt'],
                'NetWt'            => $value['NetWt'],
                'LvyrlfModecd'     => $value['LvyrlfModecd'],
                'UcnsVerno'        => $value['UcnsVerno'],
                'ClyMarkcd'        => $value['ClyMarkcd'],
                'EntryGdsSeqno'    => $value['EntryGdsSeqno'],
                'ApplyTbSeqno'     => $value['ApplyTbSeqno'],
                'DestinationNatcd' => $value['DestinationNatcd'],
                'ModfMarkcd'       => $value['ModfMarkcd'],
                'Rmk'              => $value['Rmk'],
            ];

            $this->dom = $this->createEle($InvtListTypeEle, $this->dom, $InvtListType);
        }

        $SysIdEle = [
            'SysId' => $declareConfig['SysId'],
        ];

        $this->createEle($SysIdEle, $this->dom, $InvtMessage);

        $OperCusRegCodeEle = [
            'OperCusRegCode' => $declareConfig['OperCusRegCode'],
        ];

        $this->createEle($OperCusRegCodeEle, $this->dom, $InvtMessage);

        $DelcareFlagEle = [
            'DelcareFlag' => $declareConfig['DelcareFlag'],
        ];

        $this->createEle($DelcareFlagEle, $this->dom, $BussinessData);

        return $this->dom->saveXML();
    }

    public function checkInfo($data)
    {
        //检验申报表信息
        $HeadType = $data['HeadType'];
        $list     = $data['list'];

        $HeadType_rules = [
            'SeqNo'                  => 'max:18',
            'BondInvtNo'             => 'max:64',
            'ChgTmsCnt'              => 'require|max:64',
            'PutrecNo'               => 'require|max:64',
            'InvtType'               => 'require|in:0,1,2,3,4,5,6,7,8,9',
            'EtpsInnerInvtNo'        => 'max:64',
            'BizopEtpsno'            => 'require|max:10',
            'BizopEtpsSccd'          => 'max:18',
            'BizopEtpsNm'            => 'require|max:512',
            'RcvgdEtpsno'            => 'require|max:18',
            'RvsngdEtpsSccd'         => 'max:18',
            'RcvgdEtpsNm'            => 'require|max:512',
            'DclEtpsno'              => 'require|max:10',
            'DclEtpsSccd'            => 'max:18',
            'DclEtpsNm'              => 'require|max:512',
            'InputCode'              => 'require|max:10',
            'InputCreditCode'        => 'max:18',
            'InputName'              => 'require|max:255',
            'InputTime'              => 'max:8',
            'RltInvtNo'              => 'max:64',
            'RltPutrecNo'            => 'max:64',
            'CorrEntryDclEtpsNo'     => 'max:10',
            'CorrEntryDclEtpsSccd'   => 'max:18',
            'CorrEntryDclEtpsNm'     => 'max:512',
            'RltEntryBizopEtpsno'    => 'max:10',
            'RltEntryBizopEtpsSccd'  => 'max:18',
            'RltEntryBizopEtpsNm'    => 'max:512',
            'RltEntryRcvgdEtpsno'    => 'max:10',
            'RltEntryRvsngdEtpsSccd' => 'max:18',
            'RltEntryRcvgdEtpsNm'    => 'max:512',
            'RltEntryDclEtpsno'      => 'max:10',
            'RltEntryDclEtpsSccd'    => 'max:18',
            'RltEntryDclEtpsNm'      => 'max:512',
            'ImpexpPortcd'           => 'require|max:4',
            'DclPlcCuscd'            => 'require|max:4',
            'ImpexpMarkcd'           => 'require|max:4|in:I,E',
            'MtpckEndprdMarkcd'      => 'require|max:4|in:I,E',
            'SupvModecd'             => 'require|max:6',
            'TrspModecd'             => 'require|max:6',
            'ApplyNo'                => 'max:64',
            'ListType'               => 'require|max:1',
            'DclcusFlag'             => 'require|max:1|in:1,2',
            'DclcusTypecd'           => 'max:25',
            'IcCardNo'               => 'max:20',
            'DecType'                => 'require|max:1',
            'Rmk'                    => 'max:4000',
            'StshipTrsarvNatcd'      => 'require|max:3',
            'EntryNo'                => 'max:64',
            'RltEntryNo'             => 'max:64',
            'DclTypecd'              => 'require|max:1|in:1,2,3',
            'InvtDclTime'            => 'max:18',
            // 'EntryDclTime' => 'max:18',
            'VrfdedMarkcd'     => 'max:4',
            'InvtIochkptStucd' => 'max:4',
            // 'PrevdTime' => 'max:18',
            // 'FormalVrfdedTime' => 'max:18',
            'EntryStucd'         => 'max:1',
            'PassportUsedTypeCd' => 'max:1',
            'NeedEntryModified'  => 'max:1',
            'LevyBlAmt'          => 'max:25',
            'GenDecFlag'         => 'require|max:2|in:1,2',
        ];

        $list_rules = [
            'SeqNo'            => 'max:18',
            'GdsSeqno'         => 'require|max:19',
            'PutrecSeqno'      => 'require|max:19',
            'GdsMtno'          => 'require|max:32',
            'Gdecd'            => 'require|max:10',
            'GdsNm'            => 'require|max:512',
            'GdsSpcfModelDesc' => 'require|max:255',
            'DclUnitcd'        => 'require|max:3',
            'LawfUnitcd'       => 'max:3',
            'SecdLawfUnitcd'   => 'max:3',
            'Natcd'            => 'require|max:3',
            'DclUprcAmt'       => 'require|max:19',
            'DclTotalAmt'      => 'require|max:19',
            'UsdStatTotalAmt'  => 'require|max:25',
            'DclCurrcd'        => 'require|max:3',
            'LawfQty'          => 'require|max:19',
            'SecdLawfQty'      => 'require|max:19',
            'WtSfVal'          => 'max:19',
            'FstSfVal'         => 'max:19',
            'SecdSfVal'        => 'max:19',
            'DclQt'            => 'require|max:19',
            'GrossWt'          => 'max:19',
            'NetWt'            => 'max:19',
            'LvyrlfModecd'     => 'require|max:6',
            'UcnsVerno'        => 'max:8',
            'ClyMarkcd'        => 'max:4',
            'EntryGdsSeqno'    => 'max:19',
            'ApplyTbSeqno'     => 'max:19',
            'DestinationNatcd' => 'require|max:3',
            'ModfMarkcd'       => 'require|max:1|in:0,1,2,3',
            'Rmk'              => 'max:4000',
        ];

        $this->credentialValidate->setRule($HeadType_rules);

        foreach ($HeadType as $key => $value) {
            if (!$this->credentialValidate->check($value)) {
                throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
            }
        }

        $this->credentialValidate->setRule($list_rules);

        foreach ($list as $key => $value) {
            if (!$this->credentialValidate->check($value)) {
                throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
            }
        }

        return true;
    }
}
