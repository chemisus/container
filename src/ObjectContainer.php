<?php

namespace Chemisus\Container;

use ArrayIterator;
use Traversable;

class ObjectContainer extends AbstractContainer
{
    /**
     * @var \stdClass
     */
    private $items;

    /**
     * @param null $items
     */
    public function __construct($items = null)
    {
        $this->items = $items ?: (object)[];
    }

    /**
     * @param null $value
     * @return Container
     */
    public function make(&$value = null)
    {
        $container = new ObjectContainer();
        $container->items = &$value ?: (object)[];
        return $container;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function has($key)
    {
        return property_exists($this->items, $key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->items->{$key};
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->items->{$key} = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function remove($key)
    {
        $value = $this->get($key);

        unset($this->items->{$key});

        return $value;
    }

    /**
     * @return Container
     */
    public function keys()
    {
        $items = array_keys((array)$this->items);
        return new ArrayContainer($items);
    }

    /**
     * @return Container
     */
    public function values()
    {
        $items = array_values((array)$this->items);
        return new ArrayContainer($items);
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
        return new ArrayIterator((array)$this->items);
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
        return count((array)$this->items);
    }
}