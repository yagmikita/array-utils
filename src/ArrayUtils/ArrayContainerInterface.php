<?php

namespace ArrayUtils;

interface ArrayContainerInterface
{
    /**
     * @param array $values values, to be put into an object container
     * @return $this
     */
    public function setValues(array $values = []);

    /**
     * @return array
     */
    public function getValues();
}