<?php

namespace Chemisus\Container;

class JsonContainer implements \Countable
{
    private $items;
    private $isObject;

    public function __construct($items = [])
    {
        $this->items = (array)$items;
        $this->isObject = is_object($items);
    }

    public function items()
    {
        return $this->isObject ? (object)$this->items : $this->items;
    }

    public function isObject()
    {
        return $this->isObject;
    }

    public function isArray()
    {
        return !$this->isObject;
    }

    public function count()
    {
        return count($this->items);
    }

    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function get($key)
    {
        return $this->items[$key];
    }
}