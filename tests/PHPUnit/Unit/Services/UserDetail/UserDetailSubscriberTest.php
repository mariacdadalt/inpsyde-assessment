<?php

declare(strict_types=1);

namespace Plugin\Assessment\Tests\Unit\Services\UserDetail;

use Plugin\Assessment\Tests\Unit\AbstractUnitTestcase;
use Brain\Monkey\Filters;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use DI\FactoryInterface;
use Plugin\Assessment\Services\UserDetail\UserDetailSubscriber;
use Plugin\Core\Core;
use Plugin\Core\Services\Modal\ModalController;
use Plugin\Core\Services\Loader\LoaderController;

class UserDetailSubscriberTest extends AbstractUnitTestcase
{
    /**
     * Tests that the subscribe function calls all the needed hooks.
     * SUCCESS ROUTE
     */
    public function testSubscribeCallsAllHooks()
    {
        // Assert
        Actions\expectAdded('wp_footer')->once();
        Actions\expectAdded('wp_ajax_user-detail')->once();
        Actions\expectAdded('wp_ajax_nopriv_user-detail')->once();
        Filters\expectAdded(Core::FILTER_AJAX_OBJECT)->once();

        // Arrange
        $container = $this->createStub(FactoryInterface::class);

        // Act
        $class = new UserDetailSubscriber($container);
        $class->subscribe();
    }

    /**
     * Tests that the renderModal function outputs the modal correctly.
     * SUCCESS ROUTE
     */
    public function testRenderModalOutputsCorrectly()
    {
        // Assert
        $expected = file_get_contents(__DIR__ . '/_data/ModalOutput.html');
        $this->expectOutputString($expected);

        // Arrange
        Functions\when('get_query_var')->justReturn(true);

        $modal = $this->createMock(ModalController::class);
        $modal->expects($this->once())
                 ->method('render')
                 ->with([
                    'modalID' => 'user-detail',
                    'title' => 'User Details',
                    'dismissible' => true,
                    'body' => '<div class="lds-dual-ring"></div>', ])
                ->willReturn($expected);

        $loader = $this->createMock(LoaderController::class);
        $loader->expects($this->once())
                    ->method('render')
                    ->willReturn('<div class="lds-dual-ring"></div>');

        $container = $this->createMock(FactoryInterface::class);
        $container->expects($this->any())
                        ->method('make')
                        ->withConsecutive(
                            [ ModalController::class ],
                            [ LoaderController::class ]
                        )
                        ->willReturnOnConsecutiveCalls(
                            $modal,
                            $loader
                        );

        // Act
        $class = new UserDetailSubscriber($container);
        $class->renderModal();
    }

    /**
     * Tests that the renderModal function doesn't outputs the modal when out of scope.
     * FAILURE ROUTE
     */
    public function testRenderModalIgnoresWhenOutOfScope()
    {
        // Arrange
        Functions\when('get_query_var')->justReturn(false);
        $container = $this->createStub(FactoryInterface::class);

        // Act
        $class = new UserDetailSubscriber($container);
        $class->renderModal();

        // Assert
        $this->assertEmpty($this->getActualOutput());
    }

    /**
     * Tests that the ajaxValues function adds needed values to object.
     * SUCCESS ROUTE
     */
    public function testAjaxValuesAddsValues()
    {
        // Arrange
        Functions\when('get_query_var')->justReturn(true);
        Functions\when('wp_create_nonce')->justReturn('test-nonce');
        $container = $this->createStub(FactoryInterface::class);

        // Act
        $class = new UserDetailSubscriber($container);
        $result = $class->ajaxValues([]);

        // Assert
        $this->assertArrayHasKey('nonce', $result);
        $this->assertArrayHasKey('action', $result);
    }

    /**
     * Tests that the ajaxValues function doesn't change object when out of scope.
     * FAILURE ROUTE
     */
    public function testAjaxValuesIgnoresWhenOutOfScope()
    {
        // Arrange
        Functions\when('get_query_var')->justReturn(false);
        $container = $this->createStub(FactoryInterface::class);

        // Act
        $class = new UserDetailSubscriber($container);
        $result = $class->ajaxValues([]);

        // Assert
        $this->assertArrayNotHasKey('nonce', $result);
        $this->assertArrayNotHasKey('action', $result);
    }
}
