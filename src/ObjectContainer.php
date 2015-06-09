<?php

namespace Chemisus\Container;

class ObjectContainer extends AbstractContainer
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
        $this->items = (object)$items;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function make($items = null)
    {
        return new ObjectContainer($items);
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

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return property_exists($this->items, (string)$key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if (!property_exists($this->items, $key) && array_key_exists($key, (array)$this->items)) {
            $items = (array)$this->items;
            return $items[$key];
        }

        $value = $this->items->{$key};

        if (is_object($value)) {
            return $this->make($value);
        } else if (is_array($value)) {
            return ArrayContainer::reference($this->items->{(string)$key});
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
        if ($value instanceof Container) {
            $value = $value->items();
        }

        return $this->items->{(string)$key} = $value;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function delete($key)
    {
        unset($this->items->{(string)$key});

        return $this;
    }

    /**
     * @return $this
     */
    public function keys()
    {
        return container(array_keys((array)$this->items));
    }

    /**
     * @return $this
     */
    public function values()
    {
        return container(array_values((array)$this->items));
    }

    /**
     * @return mixed
     */
    public function items()
    {
        return $this->items;
    }
}