<?php

namespace Chemisus\Container;

use Exception;

class ContainerTemplateObserver extends ArrayContainer implements ContainerObserver
{
    public function onStore($key, &$value)
    {
        $primitives = [
            'string' => 'is_string',
            'integer' => 'is_integer',
            'boolean' => 'is_bool',
            'array' => 'is_array',
            'object' => 'is_object',
            'callable' => 'is_callable',
        ];

        $passed = $this->filter(function ($type) use ($value, $primitives) {
            return (
                array_key_exists($type, $primitives)
                && call_user_func($primitives[$type], $value)
            ) || (
                is_a($value, $type)
            );
        })->count();

        if (!$passed) {
            throw new Exception('Value is none of the required types.');
        }
    }

    public function onDelete($key)
    {
    }
}