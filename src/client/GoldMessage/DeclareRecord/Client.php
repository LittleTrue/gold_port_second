<?php

namespace gold\GoldPortSecondClient\GoldMessage\DeclareRecord;

use gold\GoldPortSecondClient\Application;
use gold\GoldPortSecondClient\Base\BaseClient;
use gold\GoldPortSecondClient\Base\GoldMessageBuild;
use gold\GoldPortSecondClient\Base\Exceptions\ClientError;


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

    private $message_type = 'SAS101';

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->credentialValidate = $app['credential'];
    }

    /**
     * 业务申报表备案.
     */
    public function getDeclareRecordXml(array $declareConfig, array $declareParams)
    {

        //校验数据

        $rule = [
            'message_id'           => 'require',
            'file_name'           => 'require',
            'sender_id'           => 'require',
            'receiver_id'           => 'require',
            'OperCusRegCode'           => 'require',
            'DelcareFlag'           => 'require',
        ];

        $this->credentialValidate->setRule($rule);

        if (!$this->credentialValidate->check($declareConfig)) {
            throw new ClientError('报文传输配置' . $this->credentialValidate->getError());
        }

        $this->checkInfo($declareParams);

        //根节点生成--父类
        $this->setRootNode();

        $head = $declareParams['appHeadType'];

        $goods = $declareParams['appGoodsType'];

        //生成签名节点
        $this->createSignedInfo($this->dom,$this->nodeLink['root_node']);

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
            'version'           => $this->version,
            'message_id'           => $declareConfig['message_id'],
            'file_name'           => $declareConfig['file_name'],
            'message_type'           => $this->message_type,
            'sender_id'           => $declareConfig['sender_id'],
            'receiver_id'           => $declareConfig['receiver_id'],
            'send_time'           => $this->sendTime,
        ];

        $this->dom = $this->createEle($EnvelopInfoEle, $this->dom, $EnvelopInfo);

        $DataInfo = $this->dom->createElement('DataInfo');
        $this->nodeLink['Package']->appendchild($DataInfo);
        $this->nodeLink['DataInfo'] = $DataInfo;

        $PocketInfo = $this->dom->createElement('PocketInfo');
        $this->nodeLink['DataInfo']->appendchild($PocketInfo);


        // $BussinessData = $this->dom->createElement('BussinessData');
        // $this->nodeLink['DataInfo']->appendchild($BussinessData);
        // $this->nodeLink['BussinessData'] = $BussinessData;

        $BussinessData = $this->dom->createElement('BussinessData');
        $this->nodeLink['DataInfo']->appendchild($BussinessData);
        $this->nodeLink['BussinessData'] = $BussinessData;

        $AppMessage = $this->dom->createElement('AppMessage');
        $this->nodeLink['BussinessData']->appendchild($AppMessage);
        $this->nodeLink['AppMessage'] = $AppMessage;

        $AppHead = $this->dom->createElement('AppHead');
        $this->nodeLink['AppMessage']->appendchild($AppHead);

        $test ='';
        $AppHeadEle = [
            'SeqNo' => $head['SeqNo'],
            'SasDclNo' => $head['SasDclNo'],
            'MaserCuscd' => $head['MaserCuscd'],
            'DclTypecd' => $head['DclTypecd'],
            'BusinessTypecd' =>$head['BusinessTypecd'],
            'DirectionTypecd' => $head['DirectionTypecd'],
            'AreainOriactNo' => $head['AreainOriactNo'],
            'AreaoutOriactNo' => $head['AreaoutOriactNo'],
            'AreainEtpsno' => $head['AreainEtpsno'],
            'AreainEtpsNm' => $head['AreainEtpsNm'],
            'AreainEtpsSccd' => $head['AreainEtpsSccd'],
            'AreaoutEtpsno' =>$head['AreaoutEtpsno'],
            'AreaoutEtpsNm' => $head['AreaoutEtpsNm'],
            'AreaoutEtpsSccd' => $head['AreaoutEtpsSccd'],
            'DclEr' => $head['DclEr'],
            'DclEtpsno' => $head['DclEtpsno'],
            'DclEtpsNm' => $head['DclEtpsNm'],
            'DclEtpsSccd' => $head['DclEtpsSccd'],
            'InputCode' => $head['InputCode'],
            'InputSccd' => $head['InputSccd'],
            'InputName' => $head['InputName'],
            'MtpckEndprdTypecd' =>$head['MtpckEndprdTypecd'],
            'FreeDomes' => $head['FreeDomestic'],
        ];

        $this->dom = $this->createEle($AppHeadEle, $this->dom, $AppHead);

        $AppGoods = $this->dom->createElement('AppGoods');
        $this->nodeLink['AppMessage']->appendchild($AppGoods);

        $AppGoodsEle = [
            'SeqNo' => $goods['SeqNo'],
            'SasDclNo' => $goods['SasDclNo'],
            'SasDclSeqno' => $goods['SasDclSeqno'],
            'OriactGdsSeqno' => $goods['OriactGdsSeqno'],
            'MtpckEndprdTypecd' => $goods['MtpckEndprdTypecd'],
            'Gdecd' => $goods['Gdecd'],
            'GdsNm' => $goods['GdsNm'],
            'GdsSpcfModelDesc' =>$goods['GdsSpcfModelDesc'],
            'DclQty' => $goods['DclQty'],
            'DclUnitcd' =>$goods['DclUnitcd'],
            'DclUprcAmt' => $goods['DclUprcAmt'],
            'DclTotalAmt' => $goods['DclTotalAmt'],
            'DclCurrcd' => $goods['DclCurrcd'],
            'LicenceVaildTime' => $goods['LicenceVaildTime'],
            'GdsMarkcd' => $goods['GdsMarkcd'],
            'ModfMarkcd' => $goods['ModfMarkcd'],
            'GdsMtno' => $goods['GdsMtno'],
            'LawfUnitcd' => $goods['LawfUnitcd'],
            'SecdLawfUnitcd' => $goods['SecdLawfUnitcd'],

        ];

        $this->dom = $this->createEle($AppGoodsEle, $this->dom, $AppGoods);

        $OperCusRegCodeEle = [
            'OperCusRegCode' =>$declareConfig['OperCusRegCode'],
        ];
       
        $this->createEle($OperCusRegCodeEle, $this->dom, $AppMessage);


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
        $appGoodsType = $data['appGoodsType'];

     

        $appHeadType_rules = [
            
            'SeqNo|预录入统一编号'=> 'max:18',
            'SasDclNo|申报表编号'=> 'max:64',
            'MaserCuscd|主管关区代码'=> 'require|max:4',
            'DclTypecd|申报类型代码'=> 'require|max:1|in:1,2,3',
            'BusinessTypecd|业务类型代码'=> 'require|max:1|in:A,B,C,D,E,F,G,H,Y',
            'DirectionTypecd|货物流向代码'=> 'require|max:1|in:I,E',
            'AreainOriactNo|区内账册编号'=> 'max:64',
            'AreaoutOriactNo|区外账册编号'=> 'max:64',
            'AreainEtpsno|区内企业编码'=> 'require|max:10',
            'AreainEtpsNm|区内企业名称'=> 'require|max:512',
            'AreainEtpsSccd|区内企业社会信用代码'=> 'max:18',
            'AreaoutEtpsno|区外企业编码'=> 'max:10',
            'AreaoutEtpsNm|区外企业名称'=> 'max:512',
            'AreaoutEtpsSccd|区外企业社会信用代码'=> 'max:512',
            'ValidTime|有效期'=> 'require',
            'DclEr|申请人'=> 'require|max:256',
            'DclEtpsno|申报企业编号'=> 'require|max:10',
            'DclEtpsNm|申报企业名称'=> 'require|512',
            'DclEtpsSccd|申报企业社会信用代码'=> 'max:18',
            'InputCode|录入单位代码'=> 'require|max10',
            'InputSccd|录入单位社会信用代码'=> 'max:18',
            'InputName|录入单位名称'=> 'require|max:255',
            'MtpckEndprdTypecd|底账料件成品标志'=> 'require|max:4',
            'FreeDomestic|保税区内销标志'=> 'max:1',
        ];

        $appGoodsType_rules = [
            'SeqNo|预录入编号' => 'max:18',
            'SasDclNo|申报表编号' => 'max:64',
            'SasDclSeqno|申报序号' => 'require|max:19',
            'OriactGdsSeqno|底账商品序号' => 'require|max:19',
            'MtpckEndprdTypecd|料件成品标志代码' => 'require|max:25',
            'Gdecd|商品编码' => 'require|max:10',
            'GdsNm|商品名称' => 'require|max:512',
            'GdsSpcfModelDesc|商品规格型号描述' => 'require|255',
            'DclQty|数量' => 'number',
            'DclUnitcd|申报计量单位代码' => 'require|max:3',
            'DclUprcAmt|单价' => 'number',
            'DclTotalAmt|总价' => 'number',
            'DclCurrcd|币制代码' => 'max:3',
            // 'LicenceVaildTime|许可证有效期' => 'date',
            'GdsMarkcd|商品标记代码' => 'max:4',
            'ModfMarkcd|修改标志代码' => 'require|max:4',
            'GdsMtno|商品料号' => 'require|max:32',
            'LawfUnitcd|法定计量单位代码' => 'require|max:3',
            'SecdLawfUnitcd|法定第二计量单位代码' => 'max:3',
        ];
        $this->credentialValidate->setRule($appHeadType_rules);

        if (!$this->credentialValidate->check( $appHeadType)) {
            throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
        }

        $this->credentialValidate->setRule($appGoodsType_rules);

        if (!$this->credentialValidate->check( $appGoodsType)) {
            throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
        }

        return true;
    }
}
