<?php

class Array2Xml
{
    protected $res;
    protected $context;
    protected $charset;

    public function __construct(array $context, $charset = 'UTF-8')
    {
        if (count($context) != 1) {
            throw new Exception('There must be only one root element', 500);
        }
        $this->context = $context;
        $this->charset = $charset;
        $this->init(key($this->context));
    }

    public function conv()
    {
        return $this->formatXml($this->a2x(current($this->context), $this->res));
    }

    protected function init($root)
    {
        $header = "<?xml version=\"1.0\" encoding=\"{$this->charset}\"?><{$root}/>";
        $this->res = new SimpleXMLElement($header);
    }

    protected function addAttribs(array $attribs, SimpleXMLElement $node)
    {
        if (count($attribs)) {
            foreach ($attribs as $attrKey => $attrVal) {
                $node->addAttribute($attrKey, $attrVal);
            }
        }
        return $node;
    }

    protected function tryToAddAttribs(array $inner, SimpleXMLElement $node)
    {
        if (isset($inner['@attributes'])) {
            $this->addAttribs($inner['@attributes'], $node);
            unset($inner['@attributes']);
        }
        return $node;
    }

    protected function addEnum(array $items, SimpleXMLElement $node, $caption)
    {
        if (count($items)) {
            foreach ($items as $item) {
                $subNode = $node->addChild($caption);
                $this->tryToAddAttribs($item, $subNode);
                unset($item['@attributes']);
            }
        }
    }

    protected function a2x(array $inner, SimpleXMLElement $node)
    {
        $this->tryToAddAttribs($inner, $node);
        unset($inner['@attributes']);       
        if (count($inner)) {
            foreach ($inner as $key => $value) {
                if ($this->isEnumeration($value)) {
                    $this->addEnum($value, $node, $key);
                } else {
                    if (isset($value['@content'])) {
                        $subNode = $node->addChild($key, $value['@content']);
                    } else {
                        $subNode = $node->addChild($key);
                    }
                    unset($value['@content']);
                    if (count($value)) {
                       $this->a2x($value, $subNode);
                    }
                }
            }
        }
        return $this->res;
    }

    protected function isEnumeration(array $items)
    {
        $keys = array_keys($items);
        foreach ($keys as $key) {
            if (!is_numeric($key)) {
                return false;
            }
        }
        return true;
    }

    protected function formatXml(SimpleXMLElement $xml)
    {
        $dom = new DOMDocument("1.0");
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        return $dom->saveXML();
    }
}
