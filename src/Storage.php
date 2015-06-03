<?php

namespace Chemisus\Container;

use ArrayAccess;

interface Storage extends ArrayAccess
{
    /**
     * @param string $key
     * @return bool
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
     * @return $this
     */
    public function put($key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function remove($key);

    /**
     * @param string $key
     * @return $this
     */
    public function delete($key);

    /**
     * @return $this
     */
    public function keys();

    /**
     * @return $this
     */
    public function values();

    /**
     * @return mixed
     */
    public function items();
}
