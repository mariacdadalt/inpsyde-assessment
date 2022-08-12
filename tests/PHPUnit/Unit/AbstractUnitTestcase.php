<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Plugin\Assessment\Tests\Unit;

use Brain\Monkey;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class AbstractUnitTestcase extends MockeryTestCase
{
    /**
     * Sets up the environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    /**
     * Tears down the environment.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    /**
     * Helper to test protected and private functions.
     */
    protected function callMethod($obj, $name, array $args) //phpcs:ignore
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
