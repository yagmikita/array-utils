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
        $_context = count($this->context) ? current($this->context) : [];
        return $this->formatXml($this->a2x($_context, $this->res));
    }

    protected function init()
    {
        $rootElement = key($this->context);
        $rootContent = current($this->context);
        $header = "<?xml version=\"1.0\" encoding=\"{$this->charset}\"?><{$rootElement}/>";
        $this->res = new SimpleXMLElement($header);
        $this->tryToAddAttribs($rootContent, $this->res)
             ->tryToAddContent($rootContent, $this->res)
             ->setContext($this->validContext($rootContent));
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

    protected function tryToAddAttribs(array $context, SimpleXMLElement $node)
    {
        if (isset($context['@attributes'])) {
            $this->addAttribs($context['@attributes'], $node);
        }
        return $this;
    }

    protected function tryToAddContent(array $context, SimpleXMLElement $node)
    {
        if (isset($context['@content'])) {
            $node->{0} = $context['@content'];
        }
        return $this;
    }

    protected function addEnum(array $items, SimpleXMLElement $node, $caption)
    {
        if (count($items)) {
            foreach ($items as $item) {
                $subNode = $node->addChild($caption);
            }
        }
    }

    protected function a2x(array $context, SimpleXMLElement $node)
    {
        if (!count($context)) {
            return $this->res;
        }
        $this->tryToAddAttribs($context, $node)
             ->tryToAddContent($context, $node);
        $_context = $this->validContext($context);
        if (count($_context)) {
            foreach ($_context as $key => $value) {
                if ($this->isEnumeration($value)) {
                    $this->addEnum($value, $node, $key);
                } else {                  
                    $this->a2x($value, $node->addChild($key));
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

    protected function validContext(array $context)
    {
        $bother =[
            '@attributes' => '',
            '@content' => '',
        ];
        return array_diff_key($context, $bother);
    }

    protected function formatXml(SimpleXMLElement $xml)
    {
        $dom = new DOMDocument("1.0");
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        return $dom->saveXML();
    }
}
