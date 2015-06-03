<?php

namespace Chemisus\Container;

abstract class AbstractContainer implements Container
{
    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
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
    public function delete($key)
    {
        $this->remove($key);
        return $this;
    }

    /**
     * @param callable $callback
     * @return Container
     */
    public function map(callable $callback)
    {
        $container = $this->make();

        foreach ($this->keys() as $key) {
            $container->put($key, call_user_func($callback, $this->get($key), $key));
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
            $result = call_user_func($callback, $result, $this->get($key), $key);
        }

        return $result;
    }

    /**
     * @param callable $callback
     * @param bool|int $limit
     * @return Container
     */
    public function filter(callable $callback, $limit = false)
    {
        $container = $this->make();

        foreach ($this->keys() as $key) {
            $value = $this->get($key);

            if (call_user_func($callback, $value, $key)) {
                $container->put($key, $value);
            }

            if (is_int($limit) && count($container) >= $limit) {
                break;
            }
        }

        return $container;
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

    /**
     * @param callable|null $callback
     * @return mixed
     */
    public function first(callable $callback = null)
    {
        if (is_callable($callback)) {
            return $this->filter($callback, 1)->first();
        }

        return $this->get(array_shift($this->keys()->original()));
    }

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
}