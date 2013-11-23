<?php

namespace ArrayUtils;

class ArrayIterator extends ArrayContainer implements \Iterator
{
    protected $index;

    public function __construct(array $values = [])
    {
        $this->setValues($values);
    }

    public function setValues(array $value = [])
    {
        $this->vales = $value;
        return $this;
    }

    public function getValues()
    {
        return $this->vales;
    }

    public function key()
    {
        return $this->index;
    }

    public function current()
    {
        return $this->values[$this->index];
    }

    public function next()
    {
        $this->index++;
        if ($this->valid()) {
            return $this->current();
        }
        return null;
    }

    public function valid()
    {
        return isset($this->values[$this->index]);
    }

    public function rewind()
    {
        $this->index = 0;
        return $this->current();
    }
}
