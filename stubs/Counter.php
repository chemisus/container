<?php

namespace Chemisus\Container;

class Counter
{
    private $value;

    public function __construct($value = 0)
    {
        $this->value = $value;
    }

    public function increment()
    {
        return $this->value++;
    }
}