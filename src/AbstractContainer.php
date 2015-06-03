<?php

namespace Chemisus\Container;

use ArrayIterator;
use Traversable;

abstract class AbstractContainer implements Container
{
    /**
     * @param array $items
     * @return $this
     */
    public abstract function make($items = null);

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function put($key, $value)
    {
        $this->set($key, $value);

        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function remove($key)
    {
        $item = $this->get($key);

        $this->delete($key);

        return $item;
    }

    /**
     * @param callable $callback
     * @param null $limit
     * @return $this
     */
    public function map(callable $callback, $limit = null)
    {
        $container = $this->make();

        foreach ($this->keys() as $key) {
            if (is_numeric($limit) && count($container) >= $limit) {
                break;
            }

            $container->set($key, call_user_func($callback, $this->get($key)));
        }

        return $container;
    }

    /**
     * @param mixed $initial
     * @param callable $callback
     * @return mixed
     */
    public function reduce($initial, callable $callback)
    {
        $result = $initial;

        foreach ($this->keys() as $key) {
            $result = call_user_func($callback, $result, $this->get($key));
        }

        return $result;
    }

    /**
     * @param callable $callback
     * @param null $limit
     * @return $this
     */
    public function filter(callable $callback, $limit = null)
    {
        $container = $this->make();

        foreach ($this->keys() as $key) {
            if (is_numeric($limit) && count($container) >= $limit) {
                break;
            }

            $value = $this->get($key);

            if (call_user_func($callback, $value)) {
                $container->set($key, $value);
            }
        }

        return $container;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function each($method)
    {
        $params = func_get_args();
        array_shift($params);

        return $this->map(function ($item) use ($method, $params) {
            return call_user_func_array([$item, $method], $params);
        });
    }

    /**
     * @return $this
     */
    public function reverse()
    {
        return $this->make(array_reverse((array)$this->items()));
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public function first(callable $callback = null)
    {
        if (is_callable($callback)) {
            return $this->filter($callback, 1)->first();
        }

        return reset($this->items());
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public function last(callable $callback = null)
    {
        if (is_callable($callback)) {
            return $this->reverse()->filter($callback, 1)->last();
        }

        $items = $this->items();
        return end($items);
    }

    /**
     * @param int $offset
     * @param int $length
     * @param bool $preserve_keys
     * @return $this
     */
    public function subset($offset, $length, $preserve_keys = null)
    {
        return $this->make(array_slice((array)$this->items(), $offset, $length, $preserve_keys));
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
        return new ArrayIterator((array)$this->items());
    }

    /**
     * @param array $items
     * @return Container
     */
    public function merge($items = [])
    {
        $items = $items instanceof Container ? $items->items() : $items;
        $items = array_merge($this->items(), (array)$items);
        return $this->make($items);
    }
}
