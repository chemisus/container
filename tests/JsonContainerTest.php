<?php

namespace Chemisus\Container;

use PHPUnit_Framework_TestCase;

class JsonContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function containerProvider()
    {
        return [
            [
                'container' => new JsonContainer(),
                'isArray' => true,
                'isObject' => false,
                'type' => 'array',
                'has0' => false,
                'count' => 0,
            ],
            [
                'container' => new JsonContainer(null),
                'isArray' => false,
                'isObject' => true,
                'type' => 'object',
                'has0' => false,
                'count' => 0,
            ],
            [
                'container' => new JsonContainer(true),
                'isArray' => true,
                'isObject' => false,
                'type' => 'array',
                'has0' => true,
                'count' => 0,
            ],
            [
                'container' => new JsonContainer(false),
                'isArray' => true,
                'isObject' => false,
                'type' => 'array',
                'has0' => true,
                'count' => 1,
            ],
        ];
    }

    /**
     * @param JsonContainer $container
     * @param $isArray
     * @param $isObject
     * @param $type
     * @param $has0
     * @param $count
     *
     * @dataProvider containerProvider
     */
    public function testBasics(JsonContainer $container, $isArray, $isObject, $type, $has0, $count)
    {
        $this->assertInstanceOf('Chemisus\Container\JsonContainer', $container);
        $this->assertEquals($isArray, $container->isArray());
        $this->assertEquals($isObject, $container->isObject());
        $this->assertInternalType($type, $container->items());
        $this->assertEquals($has0, $container->has(0));
        $this->assertCount($count, $container);
    }
}
