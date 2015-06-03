<?php

namespace Chemisus\Container;

use ArrayIterator;
use Traversable;

class ArrayContainer extends AbstractContainer
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @param array $items
     */
    public function __construct($items=[]) {
        $this->items = $items;
    }

    /**
     * @param null $value
     * @return Container
     */
    public function make(&$value = null)
    {
        $container = new ArrayContainer();
        $container->items = &$value ?: [];
        return $container;
    }

    /**
     * @param string $key
     * @return mixed
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
            return $this->make($value);
        } else if (is_object($value)) {
            return new ObjectContainer($value);
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
     * @return mixed
     */
    public function remove($key)
    {
        $value = $this->get($key);

        unset($this->items[$key]);

        return $value;
    }

    /**
     * @return Container
     */
    public function keys()
    {
        $items = array_keys($this->items);
        return $this->make($items);
    }

    /**
     * @return Container
     */
    public function values()
    {
        $items = array_values($this->items);
        return $this->make($items);
    }

    /**
     * @return mixed
     */
    public function original()
    {
        return $this->items;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
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
     * @param string $method
     * @return Container
     */
    public function each($method)
    {
        $args = func_get_args();
        array_shift($args);

        return $this->map(function ($item) use ($method, $args) {
            return call_user_func_array([$item, $method], $args);
        });
    }
}