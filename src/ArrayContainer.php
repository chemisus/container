<?php

namespace Chemisus\Container;

class ArrayContainer extends AbstractContainer
{
    /**
     * @var array
     */
    private $items;

    /**
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public static function reference(&$items = null)
    {
        $container = new ArrayContainer();
        $container->items = &$items;
        return $container;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function make($items = null)
    {
        return new ArrayContainer((array)$items);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $value = $this->items[$key];

        if (is_array($value)) {
            return $this->reference($this->items[$key]);
        }

        return $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function delete($key)
    {
        unset($this->items[$key]);

        return $this;
    }

    /**
     * @return $this
     */
    public function keys()
    {
        return array_keys($this->items);
    }

    /**
     * @return $this
     */
    public function values()
    {
        return array_values($this->items);
    }

    /**
     * @return mixed
     */
    public function items()
    {
        return $this->items;
    }
}