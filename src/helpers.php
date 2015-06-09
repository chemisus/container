<?php

use Chemisus\Container\ArrayContainer;
use Chemisus\Container\Collection;
use Chemisus\Container\Container;
use Chemisus\Container\ObjectContainer;
use Chemisus\Container\Storage;

if (!function_exists('arr')) {
    /**
     * @param array $items
     * @return Container
     */
    function arr($items = [])
    {
        return container($items);
    }
}

if (!function_exists('container')) {
    /**
     * @param array $items
     * @return Container
     */
    function container($items = [])
    {
        if (is_array($items)) {
            return new ArrayContainer($items);
        }

        return new ObjectContainer($items);
    }
}

if (!function_exists('collection')) {
    /**
     * @param array $items
     * @return Collection
     */
    function collection($items = [])
    {
        return container($items);
    }
}

if (!function_exists('storage')) {
    /**
     * @param array $items
     * @return Storage
     */
    function storage($items = [])
    {
        return container($items);
    }
}
