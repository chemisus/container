<?php

namespace Chemisus\Container;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @package Chemisus\Container
 */
interface Container extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @param null $value
     * @return Container
     */
    public function make(&$value = null);

    /**
     * @param string $key
     * @return mixed
     */
    public function has($key);

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function put($key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function delete($key);

    /**
     * @param string $key
     * @return mixed
     */
    public function remove($key);

    /**
     * @return Container
     */
    public function keys();

    /**
     * @return Container
     */
    public function values();

    /**
     * @return mixed
     */
    public function original();

    /**
     * @param callable $callback
     * @return mixed
     */
    public function map(callable $callback);

    /**
     * @param string $method
     * @return Container
     */
    public function each($method);

    /**
     * @param mixed $initial
     * @param callable $callback
     * @return mixed
     */
    public function reduce($initial, callable $callback);

    /**
     * @param callable $callback
     * @param bool|int $limit
     * @return mixed
     */
    public function filter(callable $callback, $limit = false);

    /**
     * @param callable|null $callback
     * @return mixed
     */
    public function first(callable $callback = null);
}