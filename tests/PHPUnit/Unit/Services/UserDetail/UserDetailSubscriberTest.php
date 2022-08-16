<?php

declare(strict_types=1);

namespace Plugin\Assessment\Tests\Unit\Services\UserDetail;

use Plugin\Assessment\Tests\Unit\AbstractUnitTestcase;
use Brain\Monkey\Filters;
use Brain\Monkey\Actions;
use Brain\Monkey\Expectation\Exception\Exception;
use Brain\Monkey\Functions;
use DI\FactoryInterface;
use Plugin\Assessment\Services\UserDetail\UserDetailController;
use Plugin\Assessment\Services\UserDetail\UserDetailSubscriber;
use Plugin\Core\Core;
use Plugin\Core\Services\Modal\ModalController;
use Plugin\Core\Services\Loader\LoaderController;
use Plugin\Core\Services\Message\MessageController;

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

    /**
     * Tests that the endpoint function returns an error when no nonce is setup
     */
    public function testEndpointReturnsErrorNonceNotSet()
    {
        // Assert
        $expected = file_get_contents(__DIR__ . '/_data/Message01.html');
        $this->expectOutputString($expected);

        // Arrange
        $_POST['nonce'] = null;
        Functions\when('wp_send_json_error')->echoArg();

        $message = $this->createStub(MessageController::class);
        $message->expects($this->once())
                    ->method('render')
                    ->willReturn($expected);

        $container = $this->createStub(FactoryInterface::class);
        $container->expects($this->once())
                        ->method('make')
                        ->willReturn($message);

        // Act
        $class = new UserDetailSubscriber($container);
        $class->endpoint();
    }

    /**
     * Tests that the endpoint function returns an error when the nonce is not set
     * FAILURE ROUTE
     */
    public function testEndpointReturnsErrorIfNonceNotSet()
    {
        // Assert
        $expected = file_get_contents(__DIR__ . '/_data/Message01.html');
        $this->expectOutputString($expected);

        // Arrange
        $_POST['nonce'] = 'test-nonce';
        Functions\when('wp_verify_nonce')->justReturn(false);
        Functions\when('wp_send_json_error')->echoArg();

        $message = $this->createStub(MessageController::class);
        $message->expects($this->once())
                    ->method('render')
                    ->willReturn($expected);

        $container = $this->createStub(FactoryInterface::class);
        $container->expects($this->once())
                        ->method('make')
                        ->willReturn($message);

        // Act
        $class = new UserDetailSubscriber($container);
        $class->endpoint();
    }

    /**
     * Tests that the endpoint function returns an error when the nonce is invalid
     * FAILURE ROUTE
     */
    public function testEndpointReturnsSecurityError()
    {
        // Assert
        $expected = file_get_contents(__DIR__ . '/_data/Message01.html');
        $this->expectOutputString($expected);

        // Arrange
        $_POST['nonce'] = 'test-nonce';
        Functions\when('wp_verify_nonce')->justReturn(false);
        Functions\when('wp_send_json_error')->echoArg();

        $message = $this->createStub(MessageController::class);
        $message->expects($this->once())
                    ->method('render')
                    ->willReturn($expected);

        $container = $this->createStub(FactoryInterface::class);
        $container->expects($this->once())
                        ->method('make')
                        ->willReturn($message);

        // Act
        $class = new UserDetailSubscriber($container);
        $class->endpoint();
    }

    /**
     * Tests that the endpoint function returns an error when the id is not set
     */
    public function testEndpointReturnsErrorIfIDNotSet()
    {
        // Assert
        $expected = file_get_contents(__DIR__ . '/_data/Message02.html');
        $this->expectOutputString($expected);

        // Arrange
        $_POST['id'] = null;
        $_POST['nonce'] = 'test-nonce';
        Functions\when('wp_verify_nonce')->justReturn(true);
        Functions\when('wp_send_json_error')->echoArg();

        $message = $this->createStub(MessageController::class);
        $message->expects($this->once())
                    ->method('render')
                    ->willReturn($expected);

        $container = $this->createStub(FactoryInterface::class);
        $container->expects($this->once())
                        ->method('make')
                        ->willReturn($message);

        // Act
        $class = new UserDetailSubscriber($container);
        $class->endpoint();
    }

    /**
     * Tests that the endpoint function returns an error when the controller throws an exception
     */
    public function testEndpointReturnsErrorIfControllerThrowsException()
    {
        // Assert
        $expected = file_get_contents(__DIR__ . '/_data/Message03.html');
        $this->expectOutputString($expected);

        // Arrange
        $_POST['id'] = 2;
        $_POST['nonce'] = 'test-nonce';
        Functions\when('wp_verify_nonce')->justReturn(true);
        Functions\when('wp_send_json_error')->echoArg();
        Functions\when('wp_send_json_success')->echoArg();
        Functions\when('sanitize_key')->justReturn(2);

        $message = $this->createStub(MessageController::class);
        $message->expects($this->once())
                ->method('render')
                ->willReturn($expected);

        $controller = $this->createStub(UserDetailController::class);
        $controller->expects($this->once())
                ->method('render')
                ->willThrowException(new Exception());

        $container = $this->createMock(FactoryInterface::class);
        $container->expects($this->any())
                    ->method('make')
                    ->withConsecutive(
                        [ UserDetailController::class ],
                        [ MessageController::class ]
                    )
                    ->willReturnOnConsecutiveCalls(
                        $controller,
                        $message
                    );

        // Act
        $class = new UserDetailSubscriber($container);
        $class->endpoint();
    }
}
