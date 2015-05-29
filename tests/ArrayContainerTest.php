<?php

namespace Chemisus\Container;

use PHPUnit_Framework_TestCase;

class ArrayContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $container;

    public function setUp()
    {
        parent::setUp();

        $this->container = new ArrayContainer();
    }

    public function testInitialCount()
    {
        $this->assertCount(0, $this->container);
    }

    public function testPut()
    {
        $key = "a";
        $value = "b";
        $this->assertCount(0, $this->container);
        $this->assertFalse($this->container->has($key));
        $this->container->put($key, $value);
        $this->assertCount(1, $this->container);
        $this->assertTrue($this->container->has($key));
        $this->assertEquals($value, $this->container->get($key));
    }
}
