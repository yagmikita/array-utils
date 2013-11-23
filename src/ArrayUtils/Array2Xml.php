<?php

namespace ArrayUtils;

class Array2Xml extends ArrayContainer
{
    protected $res;
    protected $charset;

    public function __construct(array $values = [], $charset = 'UTF-8')
    {
        $this->setValues($values);
        $this->setCharset($charset);
    }

    public function setCharset($charset = 'UTF-8')
    {
        $this->charset = $charset;
        return $this;
    }

    public function convert()
    {
        if (count($this->getValues()) != 1) {
            throw new Exception('There must be only one root element', 500);
        }
        $this->init(key($this->getValues()));
        return $this->formatXml($this->a2x($this->getValues(), $this->res));
    }

    protected function init()
    {
        $rootElement = key($this->getValues());
        $rootContent = current($this->getValues());
        $header = "<?xml version=\"1.0\" encoding=\"{$this->charset}\"?><{$rootElement}/>";
        $this->res = new \SimpleXMLElement($header);
        $this->tryToAddAttribs($rootContent, $this->res)
             ->tryToAddContent($rootContent, $this->res)
             ->setValues($this->validValues($rootContent));
    }

    protected function addAttribs(array $attribs, \SimpleXMLElement $node)
    {
        if (count($attribs)) {
            foreach ($attribs as $attrKey => $attrVal) {
                $node->addAttribute($attrKey, $attrVal);
            }
        }
        return $node;
    }

    protected function tryToAddAttribs(array $values, \SimpleXMLElement $node)
    {
        if (!count($node->attributes())) {
            if (isset($values['@attributes'])) {
                $this->addAttribs($values['@attributes'], $node);
            }
        }
        return $this;
    }

    protected function tryToAddContent($values, \SimpleXMLElement $node)
    {
        if (isset($values['@content'])) {
            $node->{0} = $values['@content'];
        } elseif (is_string($values)) {
            $node->{0} = $values;
        }
        return $this;
    }

    protected function addEnum(array $items, \SimpleXMLElement $node, $caption)
    {
        if (count($items)) {
            foreach ($items as $item) {
                $this->loop($item, $node->addChild($caption));
            }
        }
    }

    protected function loop(array $values, \SimpleXMLElement $node)
    {
        $this->tryToAddAttribs($values, $node)
             ->tryToAddContent($values, $node);
        $context = $this->validValues($values);
        if (count($context)) {
            foreach ($context as $key => $value) {
                if ($this->isEnumeration($value)) {
                    $this->addEnum($value, $node, $key);
                } elseif (is_string($value)) {
                    $node->addChild($key, $value);
                } else {
                    $this->a2x($value, $node->addChild($key));
                }
            }
        }
    }

    protected function a2x(array $values, \SimpleXMLElement $node)
    {
        if (!count($values)) {
            return $this->res;
        }
        $this->loop($values, $node);
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

    protected function validValues(array $values)
    {
        $bother =[
            '@attributes' => '',
            '@content' => '',
        ];
        return array_diff_key($values, $bother);
    }

    protected function formatXml(\SimpleXMLElement $xml)
    {
        $dom = new \DOMDocument("1.0");
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        return $dom->saveXML();
    }
}
