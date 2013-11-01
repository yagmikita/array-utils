<?php

namespace ArrayUtils;

class Array2Xml
{
    protected $res;
    protected $context;
    protected $charset;

    public function __construct(array $context = [], $charset = 'UTF-8')
    {
        $this->setContext($context);
        $this->setCharset($charset);
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
        if (count($this->context) != 1) {
            throw new Exception('There must be only one root element', 500);
        }
        $this->init(key($this->context));
        return $this->formatXml($this->a2x($this->context, $this->res));
    }

    protected function init()
    {
        $rootElement = key($this->context);
        $rootContent = current($this->context);
        $header = "<?xml version=\"1.0\" encoding=\"{$this->charset}\"?><{$rootElement}/>";
        $this->res = new \SimpleXMLElement($header);
        $this->tryToAddAttribs($rootContent, $this->res)
             ->tryToAddContent($rootContent, $this->res)
             ->setContext($this->validContext($rootContent));
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

    protected function tryToAddAttribs(array $context, \SimpleXMLElement $node)
    {
        if (!count($node->attributes())) {
            if (isset($context['@attributes'])) {
                $this->addAttribs($context['@attributes'], $node);
            }
        }
        return $this;
    }

    protected function tryToAddContent($context, \SimpleXMLElement $node)
    {
        if (isset($context['@content'])) {
            $node->{0} = $context['@content'];
        } elseif (is_string($context)) {
            $node->{0} = $context;
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

    protected function loop(array $context, \SimpleXMLElement $node)
    {
        $this->tryToAddAttribs($context, $node)
             ->tryToAddContent($context, $node);
        $_context = $this->validContext($context);
        if (count($_context)) {
            foreach ($_context as $key => $value) {
                if ($this->isEnumeration($value)) {
                    $this->addEnum($value, $node, $key);
                } else {
                    if (is_string($value)) {
                        $node->addChild($key, $value);
                    } else {
                        $this->a2x($value, $node->addChild($key));
                    }
                }
            }
        }
    }

    protected function a2x(array $context, \SimpleXMLElement $node)
    {
        if (!count($context)) {
            return $this->res;
        }
        $this->loop($context, $node);
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

    protected function validContext(array $context)
    {
        $bother =[
            '@attributes' => '',
            '@content' => '',
        ];
        return array_diff_key($context, $bother);
    }

    protected function formatXml(\SimpleXMLElement $xml)
    {
        $dom = new \DOMDocument("1.0");
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        return $dom->saveXML();
    }
}
