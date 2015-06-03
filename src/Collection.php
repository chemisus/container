<?php

namespace Chemisus\Container;

use Countable;
use IteratorAggregate;

interface Collection extends Countable, IteratorAggregate
{
    /**
     * @param callable $callback
     * @param null $limit
     * @return $this
     */
    public function map(callable $callback, $limit = null);

    /**
     * @param mixed $initial
     * @param callable $callback
     * @return mixed
     */
    public function reduce($initial, callable $callback);

    /**
     * @param callable $callback
     * @param null $limit
     * @return $this
     */
    public function filter(callable $callback, $limit = null);

    /**
     * @param string $method
     * @return $this
     */
    public function each($method);

    /**
     * @return $this
     */
    public function reverse();

    /**
     * @param callable $callback
     * @return mixed
     */
    public function first(callable $callback = null);

    /**
     * @param callable $callback
     * @return mixed
     */
    public function last(callable $callback = null);

    /**
     * @param int $offset
     * @param int $length
     * @param bool $preserve_keys
     * @return $this
     */
    public function subset($offset, $length, $preserve_keys = null);

    /**
     * @param array $items
     * @return Container
     */
    public function merge($items = []);
}
