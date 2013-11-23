<?php

namespace ArrayUtils;

class ArrayContainer implements ArrayContainerInterface
{
    protected $values;

    public function setValues(array $values = [])
    {
        $this->values = $values;
        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }
}
