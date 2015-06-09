<?php

namespace Chemisus\Container;

use PHPUnit_Framework_TestCase;

class ObjectContainerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return Container
     */
    public function testMakeContainer()
    {
        return container((object)['a', 'b', 'c', 'd' => 'D', 'e' => 'E', 'f' => 'F']);
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testCount(Container $container)
    {
        $this->assertCount(6, $container);
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testGet(Container $container)
    {
        $this->assertEquals('a', $container[0]);
        $this->assertEquals('b', $container[1]);
        $this->assertEquals('c', $container[2]);
        $this->assertEquals('D', $container['d']);
        $this->assertEquals('E', $container['e']);
        $this->assertEquals('F', $container['f']);
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testArraySet(Container $container)
    {
        $container['g'] = 'G';
        $this->assertTrue(isset($container['g']));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testSet(Container $container)
    {
        $this->assertEquals('H', $container->set('h', 'H'));
        $this->assertTrue($container->has('h'));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testPut(Container $container)
    {
        $this->assertEquals($container, $container->put('i', 'I'));
        $this->assertTrue($container->has('i'));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testArrayUnset(Container $container)
    {
        unset($container['g']);
        $this->assertFalse(isset($container['g']));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testRemove(Container $container)
    {
        $this->assertEquals('H', $container->remove('h'));
        $this->assertFalse($container->has('h'));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testDelete(Container $container)
    {
        $this->assertEquals($container, $container->delete('i'));
        $this->assertFalse($container->has('i'));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testValues(Container $container)
    {
        $expect = ['a', 'b', 'c', 'D', 'E', 'F'];
        $this->assertEquals($expect, $container->values()->items());
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testKeys(Container $container)
    {
        $expect = [0, 1, 2, 'd', 'e', 'f'];
        $this->assertEquals($expect, $container->keys()->items());
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testItems(Container $container)
    {
        $expect = (object)[0 => 'a', 1 => 'b', 2 => 'c', 'd' => 'D', 'e' => 'E', 'f' => 'F'];
        $this->assertEquals($expect, $container->items());
    }
}
