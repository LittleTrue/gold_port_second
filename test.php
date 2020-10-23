<?php

require_once __DIR__ . '/vendor/autoload.php';

use gold\GoldPortSecondClient\Application;
use gold\GoldPortSecondService\DeclareRecordService;

$ioc_con_app = new Application();

$test = new DeclareRecordService($ioc_con_app);

$declareConfig = [
    'message_id'           => 'SAS121_20190706104235248',
    'file_name'           => 'SAS121_20190706104235248',
    'sender_id'           => '123',
    'receiver_id'           => '123',
    'OperCusRegCode'           => '操作卡海关十位代码',
    'DelcareFlag'           => '申报标志(0-暂存、1-申报)',
];

$declareParams = [
    'appHeadType'=> [
        'SeqNo'=> '预录入统一编号',
        'SasDclNo'=> '申报表编号',
        'MaserCuscd'=> '主管关区代码',
        'DclTypecd'=> '申报类型代码',
        'BusinessTypecd'=> '业务类型代码',
        'DirectionTypecd'=> '货物流向代码',
        'AreainOriactNo'=> '区内账册编号',
        'AreaoutOriactNo'=> '区外账册编号',
        'AreainEtpsno'=> '区内企业编码',
        'AreainEtpsNm'=> '区内企业名称',
        'AreainEtpsSccd'=> '区内企业社会信用代码',
        'AreaoutEtpsno'=> '区外企业编码',
        'AreaoutEtpsNm'=> '区外企业名称',
        'AreaoutEtpsSccd'=> '区外企业社会信用代码',
        'ValidTime'=> '有效期',
        'DclEr'=> '申请人',
        'DclEtpsno'=> '申报企业编号',
        'DclEtpsNm'=> '申报企业名称',
        'DclEtpsSccd'=> '申报企业社会信用代码',
        'InputCode'=> '录入单位代码',
        'InputSccd'=> '录入单位社会信用代码',
        'InputName'=> '录入单位名称',
        'EtpsPreentNo'=> '企业内部编号',
        'MtpckEndprdTypecd'=> '底账料件成品标志',
        'FreeDomestic'=> '保税区内销标志，“Y”：是，默认为空',
    ],
    'appGoodsType'=> [
        'SeqNo' => '预录入编号',
        'SasDclNo' => '申报表编号',
        'SasDclSeqno' => '申报序号',
        'OriactGdsSeqno' => '底账商品序号',
        'MtpckEndprdTypecd' => '料件成品标志代码',
        'Gdecd' => '商品编码',
        'GdsNm' => '商品名称',
        'GdsSpcfModelDesc' => '商品规格型号描述',
        'DclQty' => '数量',
        'DclUnitcd' => '申报计量单位代码',
        'DclUprcAmt' => '单价',
        'DclTotalAmt' => '总价',
        'DclCurrcd' => '币制代码',
        'LicenceVaildTime' => '许可证有效期',
        'GdsMarkcd' => '商品标记代码',
        'ModfMarkcd' => '修改标志代码',
        'GdsMtno' => '商品料号',
        'LawfUnitcd' => '法定计量单位代码',
        'SecdLawfUnitcd' => '法定第二计量单位代码',

    ],
];

var_dump($test->getDeclareRecordXml($declareConfig,$declareParams));
die();

$declareParams = [

    'data_enclosure' => [
        'FileName'          => '附件文件名称',
        'BlsNo'             => '业务单据统一编号',
        'ChgTmsCnt'         => '变更或报核次数',
        'AcmpFormFmt'       => '随附单证格式',
        'BlsType'           => '业务单证类型6-业务申报表7- 物流账册',
        'AcmpFormTypeCD'    => '随附单证类型代码',
        'AcmpFormNo'        => '随附单证编号',
        'AcmpFormFileNm'    => '随附单证文件名称',
        'IcCardNo'          => '上传人IC卡号',
        'TransferTradeCode' => '上传单位海关编码',
        'Rmk'               => '备注',
        'ModfMarkCD'        => '修改标记代码 0-未修改 1-修改  3-增加',
        'TotalPocketQty'    => '总包数',
        'CurPocketNo'       => '当前包序号',
        'PocketId'          => '包ID(通一票数据包id必须相同)',
    ],


    'data_declaration' => [
        'appMessage' => [
            'annotation'=> '申报表暂存、申报请求报文/明细查询响应报文',
            'AppHeadType'=> '申报表预录入表头',
            'AppGoods'=> '申报表预录入表体',
            'AppUcns'=> '申报表单耗预录入表体',
            'OperCusRegCode'=> '操作卡的海关十位',
            'AppHeadType'=> '申报表预录入表头',
        ],
        'appHeadType'=> [
            'annotation'=> '申报表表头',
            'SeqNo'=> '预录入统一编号',
            'SasDclNo'=> '申报表编号',
            'MaserCuscd'=> '主管关区代码',
            'DclTypecd'=> '申报类型代码',
            'BusinessTypecd'=> '业务类型代码',
            'DirectionTypecd'=> '货物流向代码',
            'AreainOriactNo'=> '区内账册编号',
            'AreaoutOriactNo'=> '区外账册编号',
            'AreainEtpsno'=> '区内企业编码',
            'AreainEtpsNm'=> '区内企业名称',
            'AreainEtpsSccd'=> '区内企业社会信用代码',
            'AreaoutEtpsno'=> '区外企业编码',
            'AreaoutEtpsNm'=> '区外企业名称',
            'AreaoutEtpsSccd'=> '区外企业社会信用代码',
            'DpstLevyBlNo'=> '保证金征收单编号',
            'ValidTime'=> '有效期',
            'DclEr'=> '申请人',
            'ExhibitionPlace'=> '展示地',
            'DclEtpsno'=> '申报企业编号',
            'DclEtpsNm'=> '申报企业名称',
            'DclEtpsSccd'=> '申报企业社会信用代码',
            'InputCode'=> '录入单位代码',
            'InputSccd'=> '录入单位社会信用代码',
            'InputName'=> '录入单位名称',
            'EtpsPreentNo'=> '企业内部编号',
            'MtpckEndprdTypecd'=> '底账料件成品标志',
            'Rmk'=> '备注',
            'Col1'=> '边角料标志，1：是，默认为空',
            'Col2'=> '备用字段2',
            'Col3'=> '备用字段3',
            'Col4'=> '备用字段4',
            'Col4Cus'=> '担保征收比例',
            'FreeDomestic'=> '保税区内销标志，“Y”：是，默认为空',
        ],
        'appGoodsType'=> [
            'SeqNo' => '预录入编号',
            'SasDclNo' => '申报表编号',
            'SasDclSeqno' => '申报序号',
            'OriactGdsSeqno' => '底账商品序号',
            'MtpckEndprdTypecd' => '料件成品标志代码',
            'Gdecd' => '商品编码',
            'GdsNm' => '商品名称',
            'GdsSpcfModelDesc' => '商品规格型号描述',
            'DclQty' => '数量',
            'DclUnitcd' => '申报计量单位代码',
            'DclUprcAmt' => '单价',
            'DclTotalAmt' => '总价',
            'DclCurrcd' => '币制代码',
            'LicenceNo' => '许可证编号',
            'LicenceVaildTime' => '许可证有效期',
            'GdsMarkcd' => '商品标记代码',
            'GdsRmk' => '商品备注',
            'ModfMarkcd' => '修改标志代码',
            'Rmk' => '备注',
            'GdsMtno' => '商品料号',
            'LawfUnitcd' => '法定计量单位代码',
            'SecdLawfUnitcd' => '法定第二计量单位代码',
            'EndprdGdsTypecd' => '成品类型',
            'Col1' => '备用字段1',
            'Col2' => '备用字段2',
            'Col3' => '备用字段3',
            'Col4' => '备用字段4',
        ],
        'appUcnsType'=> [
            'SeqNo' => '预录入统一编号',
            'SasDclNo' => '申报表编号',
            'EndprdSeqno' => '预录入统一编号',
            'MtpckSeqno' => '料件备案序号',
            'NetUseupQty' => '净耗数量',
            'LossRate' => '损耗率',
            'ModfMarkcd' => '修改标志代码',
            'Col1' => '备用字段1',
            'Col2' => '备用字段2',
            'Col3' => '备用字段3',
            'Col4' => '备用字段4',
        ],
    ]
   
    
];

