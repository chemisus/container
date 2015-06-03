<?php

namespace Chemisus\Container;

interface Container
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
     * @return Container
     */
    public function put($key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function remove($key);

    /**
     * @param string $key
     * @return Container
     */
    public function delete($key);
}
