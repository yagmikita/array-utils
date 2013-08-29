<?php

class Array2Xml
{
    protected $res;
    protected $context;
    protected $charset;

    public function __construct(array $context = [], $charset = 'UTF-8')
    {
        if (count($context) != 1) {
            throw new Exception('There must be only one root element', 500);
        }
        $this->setContext($context);
        $this->setCharset($charset);
        $this->init(key($this->context));
    }

    public function setContext(array $context = [])
    {
        $this->context = $context;
        return $this;
    }

    public function setCharset($charset = 'UTF-8')
    {
        $this->charset = $charset;
        return $this;
    }

    public function conv()
    {
        if (!count($this->context)) {
            throw new Exception("Array is not set", 500);
        }
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
                    //var_dump($key, $value);
                    if (isset($value['@content'])) {
                        $subNode = $node->addChild($key, $value['@content']);
                        unset($value['@content']);
                    } else {
                        if ($key != '@content') {
                            $subNode = $node->addChild($key);
                        }
                    }
                    if ($key == '@content' && is_string($value)) {
                        $subNode = $node->addChild($key, $value);
                    } else {
                        //var_dump($key, $value, $subNode->getName());
                        $this->a2x($value, $subNode);
                    }
                }
            }
        }
        return $this->res;
    }

    protected function isEnumeration($items)
    {
        if (is_string($items)) {
            return false;
        }
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
        //var_dump($xml->asXML());
        $dom = new DOMDocument("1.0");
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        return $dom->saveXML();
    }
}
