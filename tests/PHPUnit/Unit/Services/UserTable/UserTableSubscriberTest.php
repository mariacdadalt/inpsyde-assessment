<?php

declare(strict_types=1);

namespace Plugin\Assessment\Tests\Unit\Services\UserTable;

use Plugin\Assessment\Tests\Unit\AbstractUnitTestcase;
use Brain\Monkey\Filters;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use DI\Container;
use Plugin\Assessment\Services\UserTable\UserTableSubscriber;

class UserTableSubscriberTest extends AbstractUnitTestcase
{
    /**
     * Tests that the subscribe function calls all the needed hooks.
     * SUCCESS ROUTE
     */
    public function testSubscribeCallsAllHooks()
    {
        // Assert
        Actions\expectAdded('init')->once();
        Filters\expectAdded('request')->once();
        Filters\expectAdded('template_include')->once();

        // Arrange
        $container = $this->createStub(Container::class);

        // Act
        $class = new UserTableSubscriber($container);
        $class->subscribe();
    }

    /**
     * Testes that the addEndpoint function calls add_rewrite_endpoint
     * with the right arguments.
     * SUCCESS ROUTE
     */
    public function testAddEndpointCallsWPFunction()
    {
        // Assert
        Functions\expect('add_rewrite_endpoint')
        ->once()
        ->with('user-table', EP_ROOT);

        // Arrange
        $container = $this->createStub(Container::class);

        // Act
        $class = new UserTableSubscriber($container);
        $class->addEndpoint();
    }

    /**
     * Tests that the addQueryVar function sets the user-table var to true.
     * SUCCESS ROUTE
     */
    public function testAddQueryVarSetsUserTableToTrue()
    {
        // Arrange
        $container = $this->createStub(Container::class);
        $vars = [
            'user-table' => '',
        ];

        // Act
        $class = new UserTableSubscriber($container);
        $result = $class->addQueryVar($vars);

        // Assert
        $this->assertTrue($result['user-table']);
    }

    /**
     * Tests that the addQueryVar function properly ignores the var when the user-table
     * key doesn't exists.
     * FAILURE ROUTE
     */
    public function testAddQueryVarIgnoresWhenVarNotAvailable()
    {
        // Arrange
        $container = $this->createStub(Container::class);
        $vars = [
            'some-other-key' => '',
        ];

        // Act
        $class = new UserTableSubscriber($container);
        $result = $class->addQueryVar($vars);

        // Assert
        $this->assertArrayNotHasKey('user-table', $result);
    }

    /**
     * Tests that the interceptTemplate function returns the UserTableTemplate.php
     * SUCCESS ROUTE
     */
    public function testInterceptTemplateReturnsUserTableTemplate()
    {
        // Arrange
        $container = $this->createStub(Container::class);
        $template = 'not-the-right-template.php';

        Functions\when('get_query_var')->justReturn(true);

        // Act
        $class = new UserTableSubscriber($container);
        $result = $class->interceptTemplate($template);

        // Assert
        $this->assertStringContainsString('UserTableTemplate.php', $result);
    }

    /**
     * Tests that the interceptTemplate function returns the original template.
     * FAILURE ROUTE
     */
    public function testInterceptTemplateReturnOriginal()
    {
        // Arrange
        $container = $this->createStub(Container::class);
        $template = 'not-the-right-template.php';

        Functions\when('get_query_var')->justReturn(false);

        // Act
        $class = new UserTableSubscriber($container);
        $result = $class->interceptTemplate($template);

        // Assert
        $this->assertStringContainsString($template, $result);
    }
}
