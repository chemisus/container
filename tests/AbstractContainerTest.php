<?php

namespace Chemisus\Container;

use PHPUnit_Framework_TestCase;
use stdClass;

class AbstractContainerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return Container
     */
    public function testMakeContainer()
    {
        return new ArrayContainer(['a', 'b', 'c', 'd' => 'D', 'e' => 'E', 'f' => 'F']);
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testMap(Container $container)
    {
        $this->assertEquals('ABCDEF', implode('', $container->map('strtoupper')->items()));
        $this->assertEquals('abcdef', implode('', $container->map('strtolower')->items()));

        $this->assertEquals('abc', implode('', $container->map('strtolower', 3)->items()));
        $this->assertEquals('abcd', implode('', $container->map('strtolower', 4)->items()));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testReduce(Container $container)
    {
        $actual = $container->reduce(0, function ($result, $value) {
            return $result . $value;
        });

        $this->assertEquals('0abcDEF', $actual);
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testFilter(Container $container)
    {
        $this->assertEquals('abc', implode('', $container->filter(function ($value) {
            return $value === strtolower($value);
        })->items()));

        $this->assertEquals('DEF', implode('', $container->filter(function ($value) {
            return $value === strtoupper($value);
        })->items()));

        $this->assertEquals('DE', implode('', $container->filter(function ($value) {
            return $value === strtoupper($value);
        }, 2)->items()));

        $this->assertEquals('D', implode('', $container->filter(function ($value) {
            return $value === strtoupper($value);
        }, 1)->items()));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testFirst(Container $container)
    {
        $this->assertEquals('a', $container->first());

        $this->assertEquals('a', $container->first(function ($value) {
            return strtolower($value) === $value;
        }));

        $this->assertEquals('D', $container->first(function ($value) {
            return strtoupper($value) === $value;
        }));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testLast(Container $container)
    {
        $this->assertEquals('F', $container->last());

        $this->assertEquals('F', $container->last(function ($value) {
            return strtoupper($value) === $value;
        }));

        $this->assertEquals('c', $container->last(function ($value) {
            return strtolower($value) === $value;
        }));
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testEach(Container $container)
    {
        $counter = new Counter();
        $container = new ArrayContainer([$counter, $counter, $counter]);
        $actual = [0, 1, 2];
        $this->assertEquals($actual, $container->each('increment')->values());
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testOffset(Container $container)
    {
        $this->assertEquals(['c', 'D', 'E'], $container->subset(2, 3)->values());
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testMerge(Container $container)
    {
        $this->assertEquals(['a', 'b', 'c', 'D', 'E', 'F', '999'], $container->merge(['999'])->values());
        $this->assertEquals(['a', 'b', 'c', 'D', 'E', 'F'], $container->values());
    }

    /**
     * @param Container $container
     * @depends testMakeContainer
     */
    public function testIterator(Container $container)
    {
        $iterator = $container->getIterator();

        $this->assertEquals(0, $iterator->key());
        $this->assertEquals('a', $iterator->current());
        $this->assertEquals(0, $iterator->key());
        $this->assertEquals('a', $iterator->current());
        $iterator->next();
        $this->assertEquals(1, $iterator->key());
        $this->assertEquals('b', $iterator->current());
        $iterator->next();
        $this->assertEquals(2, $iterator->key());
        $this->assertEquals('c', $iterator->current());
    }
}
