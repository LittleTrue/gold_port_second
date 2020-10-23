<?php

namespace gold\GoldPortSecondClient\Base;

/**
 * Trait CebMessageBuild.
 */
trait GoldMessageBuild
{
    /**
     * @var array 根节点操作和子类共享数组
     */
    public $nodeLink = [];

    /**
     * @var object dom节点链对象
     */
    public $dom;

    /**
     * @var object 报文版本
     */
    protected $version = '1.0';

    /**
     * 生成报文根节点,dom操作类.
     */
    public function setRootNode()
    {
        $this->dom = new \DomDocument('1.0', 'UTF-8');
        $root_node = $this->dom->createElement('xs:schema');
        $this->dom->appendchild($root_node);

        $root_node->setAttribute('xmlns:xs', 'http://www.w3.org/2001/XMLSchema');
        $root_node->setAttribute('elementFormDefault', 'qualified');
        $root_node->setAttribute('attributeFormDefault', 'unqualified');

        //文档ceb根结点, 根节点和对应的节点用数组存储
        $this->nodeLink['root_node'] = $root_node;

        return true;
    }

    //生成含值的节点
    public function createEle($element, $dom, $parents)
    {
        foreach ($element as $key => $value) {
            $note = $dom->createElement($key);
            $parents->appendchild($note);
            $zhi = $dom->createTextNode($value);
            $note->appendchild($zhi);
        }
        return $dom;
    }

    /**
     * 创建“xs:annotation” 节点.
     */
    public function createAnnotation($dom, $parents, $data)
    {
        $annotation = $this->dom->createElement('xs:annotation');
        $parents->appendchild($annotation);
        // $this->nodeLink['annotation'] = $annotation;
        $this->dom = $this->createEle($data, $this->dom, $annotation);

        return $dom;
    }

    /**
     * 创建“xs:simpleType” 节点.
     */
    public function createSimpleType($dom, $parents, $data)
    {
        $simpleType = $this->dom->createElement('xs:simpleType');
        $parents->appendchild($simpleType);
        $this->nodeLink['simpleType'] = $simpleType;

        $restriction = $this->dom->createElement('xs:restriction');
        $restriction->setAttribute('base', $data['base']);
        $this->nodeLink['simpleType']->appendchild($restriction);
        $this->nodeLink['restriction'] = $restriction;

        $maxLength = $this->dom->createElement('xs:maxLength');
        if (isset($data['value']) && !empty($data['value'])) {
            $maxLength->setAttribute('value', $data['value']);
            $this->nodeLink['restriction']->appendchild($maxLength);
        }

        return $dom;
    }
}
