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
        $this->checkInfo($declareParams);

        //根节点生成--父类
        $this->setRootNode();

        //生成附件信息
        $this->createEnclosure($this->dom, $declareParams['data_enclosure']);

        //生成申报表信息
        $this->createDeclaration($this->dom, $declareParams['data_declaration']);

        //公共信息

        return $this->dom->saveXML();
    }

    /**
     * 创建附件节点.
     */
    public function createEnclosure($dom, $data)
    {
        $complexType = $this->dom->createElement('xs:complexType');
        $this->nodeLink['root_node']->appendchild($complexType);
        $complexType->setAttribute('name', 'SasAcmpRLType');
        $this->nodeLink['complexType'] = $complexType;

        $this->createAnnotation($this->dom, $this->nodeLink['complexType'], ['xs:documentation' => '附件关系表']);

        $sequence = $this->dom->createElement('xs:sequence');
        $this->nodeLink['complexType']->appendchild($sequence);
        $this->nodeLink['sequence'] = $sequence;

        //FileName
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'FileName');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['FileName']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //BlsNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'BlsNo');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['BlsNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //ChgTmsCnt
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'ChgTmsCnt');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['ChgTmsCnt']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //AcmpFormFmt
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AcmpFormFmt');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['AcmpFormFmt']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '4']);

        //BlsType
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'BlsType');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['BlsType']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '4']);

        //AcmpFormTypeCD
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AcmpFormTypeCD');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['AcmpFormTypeCD']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '25']);

        //AcmpFormNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AcmpFormNo');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['AcmpFormNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //AcmpFormFileNm
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AcmpFormFileNm');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['AcmpFormFileNm']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '10']);

        //IcCardNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'IcCardNo');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['IcCardNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '16']);

        //TransferTradeCode
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'TransferTradeCode');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['TransferTradeCode']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //Rmk
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Rmk');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Rmk']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '4000']);

        //ModfMarkCD
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'ModfMarkCD');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['ModfMarkCD']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string']);

        //total_pocket_qty
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'total_pocket_qty');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['TotalPocketQty']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string']);

        //cur_pocket_no
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'cur_pocket_no');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['CurPocketNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string']);

        //pocket_id
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'pocket_id');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['PocketId']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string']);

        $element = $this->dom->createElement('xs:element');
        $this->nodeLink['root_node']->appendchild($element);
        $complexType->setAttribute('name', 'SasAcmpRLMessage');
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['complexType'], ['xs:documentation' => '附件关系请求/响应']);

        $complexType = $this->dom->createElement('xs:complexType');
        $this->nodeLink['element']->appendchild($complexType);
        $this->nodeLink['complexType'] = $complexType;

        $sequence = $this->dom->createElement('xs:sequence');
        $this->nodeLink['complexType']->appendchild($sequence);
        $this->nodeLink['sequence'] = $sequence;

        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SasAcmpRLList');
        $element->setAttribute('type', 'SasAcmpRLType');
        $element->setAttribute('maxOccurs', 'unbounded');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => '附件关系表']);

        return $this->dom;
    }

    /*
     * 生成申报表节点
     */
    public function createDeclaration($dom, $data)
    {
        $appMessage   = $data['appMessage'];
        $appHeadType  = $data['appHeadType'];
        $appGoodsType = $data['appGoodsType'];
        $appUcnsType  = $data['appUcnsType'];

        $element = $this->dom->createElement('xs:element');
        $this->nodeLink['root_node']->appendchild($element);
        $element->setAttribute('name', 'AppMessage');
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' =>  $appMessage['annotation']]);

        $complexType = $this->dom->createElement('xs:complexType');
        $this->nodeLink['element']->appendchild($complexType);
        $this->nodeLink['complexType'] = $complexType;

        $sequence = $this->dom->createElement('xs:sequence');
        $this->nodeLink['complexType']->appendchild($sequence);
        $this->nodeLink['sequence'] = $sequence;

        //AppHeadType
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AppHead');
        $element->setAttribute('type', 'AppHeadType');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appMessage['AppHeadType']]);

        //AppGoods
        $element = $this->dom->createElement('xs:AppGoods');
        $element->setAttribute('name', 'AppGoods');
        $element->setAttribute('type', 'AppGoodsType');
        $element->setAttribute('maxOccurs', 'unbounded');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appMessage['AppGoods']]);

        //AppUcns
        $element = $this->dom->createElement('xs:AppGoods');
        $element->setAttribute('name', 'AppUcns');
        $element->setAttribute('type', 'AppUcnsType');
        $element->setAttribute('maxOccurs', 'unbounded');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appMessage['AppUcns']]);

        //OperCusRegCode
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'OperCusRegCode');
        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appMessage['OperCusRegCode']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '10']);

        $complexType = $this->dom->createElement('xs:complexType');
        $this->nodeLink['root_node']->appendchild($complexType);
        $complexType->setAttribute('name', 'AppHeadType');
        $this->nodeLink['complexType'] = $complexType;

        $this->createAnnotation($this->dom, $this->nodeLink['complexType'], ['xs:documentation' => $appHeadType['annotation']]);

        $sequence = $this->dom->createElement('xs:sequence');
        $this->nodeLink['complexType']->appendchild($sequence);
        $this->nodeLink['sequence'] = $sequence;

        //SeqNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SeqNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['SeqNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //SasDclNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SasDclNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['SasDclNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //MaserCuscd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'MaserCuscd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['MaserCuscd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '4']);

        //DclTypecd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclTypecd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['DclTypecd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '1']);

        //BusinessTypecd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'BusinessTypecd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['BusinessTypecd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '1']);

        //DirectionTypecd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DirectionTypecd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['DirectionTypecd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '1']);

        //AreainOriactNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreainOriactNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreainOriactNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //AreaoutOriactNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreaoutOriactNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreaoutOriactNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //AreainEtpsno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreainEtpsno');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreainEtpsno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '10']);

        //AreainEtpsNm
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreainEtpsNm');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreainEtpsNm']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //AreainEtpsSccd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreainEtpsSccd');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreainEtpsSccd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //AreaoutEtpsno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreaoutEtpsno');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreaoutEtpsno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '10']);

        //AreaoutEtpsNm
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreaoutEtpsno');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreaoutEtpsNm']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //AreaoutEtpsSccd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'AreaoutEtpsSccd');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['AreaoutEtpsSccd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //DpstLevyBlNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DpstLevyBlNo');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['DpstLevyBlNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //ValidTime
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'ValidTime');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['ValidTime']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //DclEr
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclEr');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['DclEr']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '256']);

        //ExhibitionPlace
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'ExhibitionPlace');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['ExhibitionPlace']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //DclEtpsno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclEtpsno');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['DclEtpsno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '10']);

        //DclEtpsNm
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclEtpsNm');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['DclEtpsNm']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //DclEtpsSccd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclEtpsSccd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['DclEtpsSccd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //InputCode
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'InputCode');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['InputCode']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '10']);

        //InputSccd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'InputSccd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['InputSccd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //InputName
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'InputName');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['InputName']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //EtpsPreentNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'EtpsPreentNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['EtpsPreentNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //MtpckEndprdTypecd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'MtpckEndprdTypecd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['MtpckEndprdTypecd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '24']);

        //Rmk
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Rmk');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['Rmk']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //Col1
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col1');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['Col1']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col2
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col2');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' =>$appHeadType['Col2']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col3
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col3');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['Col3']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col4
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col4');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['Col4']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col4Cus
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col4Cus');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['Col4Cus']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //FreeDomestic
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'FreeDomestic');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $appHeadType['FreeDomestic']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '1']);

        //业务申报表商品表体------AppGoodsType
        $this->createAppGoodsType($this->dom, $appGoodsType);

        //创建业务申报表单耗表体------AppUcnsType
        $this->createAppUcnsType($this->dom,$appUcnsType);

        
    }

    /**
     * 业务申报表商品表体------AppGoodsType.
     */
    public function createAppGoodsType($dom, $data)
    {

        $complexType = $this->dom->createElement('xs:complexType');
        $this->nodeLink['root_node']->appendchild($complexType);
        $complexType->setAttribute('name', 'AppGoodsType');
        $this->nodeLink['complexType'] = $complexType;

        $this->createAnnotation($this->dom, $this->nodeLink['complexType'], ['xs:documentation' => '申报表商品表体']);

        $sequence = $this->dom->createElement('xs:sequence');
        $this->nodeLink['complexType']->appendchild($sequence);
        $this->nodeLink['sequence'] = $sequence;

        //SeqNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SeqNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['SeqNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //SasDclNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SasDclNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['SasDclNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //SasDclSeqno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SasDclSeqno');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['SasDclSeqno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //OriactGdsSeqno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'OriactGdsSeqno');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['OriactGdsSeqno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //MtpckEndprdTypecd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'MtpckEndprdTypecd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['MtpckEndprdTypecd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '25']);

        //Gdecd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Gdecd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Gdecd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '10']);

        //GdsNm
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'GdsNm');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['GdsNm']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //GdsSpcfModelDesc
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'GdsSpcfModelDesc');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['GdsSpcfModelDesc']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //DclQty
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclQty');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['DclQty']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '25']);

        //DclUnitcd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclUnitcd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['DclUnitcd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '3']);

        //DclUprcAmt
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclUprcAmt');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['DclUprcAmt']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '31']);

        //DclTotalAmt
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclTotalAmt');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['DclTotalAmt']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '31']);

        //DclCurrcd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'DclCurrcd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['DclCurrcd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '3']);

        //LicenceNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'LicenceNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['LicenceNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '30']);

        //LicenceVaildTime
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'LicenceVaildTime');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['LicenceVaildTime']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //GdsMarkcd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'GdsMarkcd');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['GdsMarkcd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '4']);

        //GdsRmk
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'GdsRmk');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['GdsRmk']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '40000']);

        //ModfMarkcd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'ModfMarkcd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['ModfMarkcd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '4']);

        //Rmk
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Rmk');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Rmk']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //GdsMtno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'GdsMtno');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['GdsMtno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '32']);

        //LawfUnitcd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'LawfUnitcd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['LawfUnitcd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '3']);

        //SecdLawfUnitcd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SecdLawfUnitcd');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['SecdLawfUnitcd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '512']);

        //EndprdGdsTypecd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'EndprdGdsTypecd');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['EndprdGdsTypecd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '4']);

        //Col1
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col1');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col1']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col2
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col2');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col2']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col3
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col3');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col3']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col4
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col4');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col4']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);
    }

    /**
     * 业务申报表单耗表体------AppUcnsType.
     */
    public function createAppUcnsType($dom, $data)
    {

        $complexType = $this->dom->createElement('xs:complexType');
        $this->nodeLink['root_node']->appendchild($complexType);
        $complexType->setAttribute('name', 'AppUcnsType');
        $this->nodeLink['complexType'] = $complexType;

        $this->createAnnotation($this->dom, $this->nodeLink['complexType'], ['xs:documentation' => '申报表单耗表体']);

        $sequence = $this->dom->createElement('xs:sequence');
        $this->nodeLink['complexType']->appendchild($sequence);
        $this->nodeLink['sequence'] = $sequence;

        //SeqNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SeqNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['SeqNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '18']);

        //SasDclNo
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'SasDclNo');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['SasDclNo']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //EndprdSeqno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'EndprdSeqno');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['EndprdSeqno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //EndprdSeqno
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'MtpckSeqno');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['EndprdSeqno']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '19']);

        //NetUseupQty
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'NetUseupQty');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['NetUseupQty']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '29']);

        //LossRate
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'LossRate');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['LossRate']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '29']);

        //ModfMarkcd
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'ModfMarkcd');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['ModfMarkcd']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '64']);

        //Col1
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col1');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col1']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col2
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col2');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col2']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col3
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col3');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col3']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);

        //Col4
        $element = $this->dom->createElement('xs:element');
        $element->setAttribute('name', 'Col4');
        $element->setAttribute('minOccurs', '0');

        $this->nodeLink['sequence']->appendchild($element);
        $this->nodeLink['element'] = $element;

        $this->createAnnotation($this->dom, $this->nodeLink['element'], ['xs:documentation' => $data['Col4']]);
        $this->createSimpleType($this->dom, $this->nodeLink['element'], ['base' => 'xs:string', 'value' => '255']);
    }

    public function checkInfo($data)
    {
        //检验附件信息   
        $enclosure_rules = [
            'FileName|附件文件名称'          => 'max:64',
            'BlsNo|业务单据统一编号'             => 'max:18',
            'ChgTmsCnt|变更或报核次数'         => 'number',
            'AcmpFormFmt|随附单证格式'       => 'require|max:4|in:1,2',
            'BlsType|业务单证类型'           => 'require|max:4|in:6,7',
            'AcmpFormTypeCD|随附单证类型代码'    => 'max:25',
            'AcmpFormNo|随附单证编号'        => 'number',
            'AcmpFormFileNm|随附单证文件名称'    => 'max:512',
            'IcCardNo|上传人IC卡号'          => 'require',
            'TransferTradeCode|上传单位海关编码' => 'max:18',
            'Rmk|备注'               => 'max:400',
            'ModfMarkCD|修改标记代码'        => 'require',
            'TotalPocketQty|总包数'    => 'number',
            'CurPocketNo|当前包序号'       => 'number',
            'PocketId|包ID'          => 'max:128',
        ];

        $this->credentialValidate->setRule($enclosure_rules);

        if (!$this->credentialValidate->check($data['data_enclosure'])) {
            throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
        }

        //检验申报表信息
        $data_declaration = $data['data_declaration'];
        $appMessage   = $data_declaration['appMessage'];
        $appHeadType  = $data_declaration['appHeadType'];
        $appGoodsType = $data_declaration['appGoodsType'];
        $appUcnsType  = $data_declaration['appUcnsType'];


        $appMessage_rules = [
            'annotation|申报表暂存、申报请求报文/明细查询响应报文'=> 'require',
            'AppHeadType|申报表预录入表头'=> 'require',
            'AppGoods|申报表预录入表体'=> 'require',
            'AppUcns|申报表单耗预录入表体'=> 'require',
            'OperCusRegCode|操作卡的海关十位'=> 'require',
            'AppHeadType|申报表预录入表头'=> 'require',
        ];

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
            'DpstLevyBlNo|保证金征收单编号'=> 'max:64',
            'ValidTime|有效期'=> 'require',
            'DclEr|申请人'=> 'require|max:256',
            'ExhibitionPlace|展示地'=> 'max:512',
            'DclEtpsno|申报企业编号'=> 'require|max:10',
            'DclEtpsNm|申报企业名称'=> 'require|512',
            'DclEtpsSccd|申报企业社会信用代码'=> 'max:18',
            'InputCode|录入单位代码'=> 'require|max10',
            'InputSccd|录入单位社会信用代码'=> 'max:18',
            'InputName|录入单位名称'=> 'require|max:255',
            'EtpsPreentNo|企业内部编号'=> 'require|64',
            'MtpckEndprdTypecd|底账料件成品标志'=> 'reqquire|max:4',
            'Rmk|备注'=> 'max:512',
            'Col1|边角料标志'=> 'max:255',
            'Col2|备用字段2'=> 'max:255',
            'Col3|备用字段3'=> 'max:255',
            'Col4|备用字段4'=> 'max:255',
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
            'LicenceNo|许可证编号' => 'max:30',
            // 'LicenceVaildTime|许可证有效期' => 'date',
            'GdsMarkcd|商品标记代码' => 'max:4',
            'GdsRmk|商品备注' => 'max:4000',
            'ModfMarkcd|修改标志代码' => 'require|max:4',
            'Rmk|备注' => 'max:512',
            'GdsMtno|商品料号' => 'require|max:32',
            'LawfUnitcd|法定计量单位代码' => 'require|max:3',
            'SecdLawfUnitcd|法定第二计量单位代码' => 'max:3',
            'EndprdGdsTypecd|成品类型' => 'max:4',
            'Col1|备用字段1' => 'max:255',
            'Col2|备用字段2' => 'max:255',
            'Col3|备用字段3' => 'max:255',
            'Col4|备用字段4' => 'max:255',
        ];

        $appUcnsType_rules = [
            'SeqNo|' => 'max:18',
            'SasDclNo|' => 'max:64',
            'EndprdSeqno|' => 'require|number',
            'MtpckSeqno|' => 'require|number',
            'NetUseupQty|' => 'require|number',
            'LossRate|' => 'require|number',
            'ModfMarkcd|' => 'require|max:4',
            'Col1|' => 'max:255',
            'Col2|' => 'max:255',
            'Col3|' => 'max:255',
            'Col4|' => 'max:255',
        ];

        $this->credentialValidate->setRule($appMessage_rules);

        if (!$this->credentialValidate->check( $appMessage)) {
            throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
        }

        $this->credentialValidate->setRule($appHeadType_rules);

        if (!$this->credentialValidate->check( $appHeadType)) {
            throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
        }

        $this->credentialValidate->setRule($appGoodsType_rules);

        if (!$this->credentialValidate->check( $appGoodsType)) {
            throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
        }

        $this->credentialValidate->setRule($appUcnsType_rules);

        if (!$this->credentialValidate->check( $appUcnsType)) {
            throw new ClientError('报文清单数据: ' . $this->credentialValidate->getError());
        }

        return true;
    }
}
