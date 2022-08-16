<?php

declare(strict_types=1);

namespace Plugin\Assessment\Tests\Unit\Services\UserDetail;

use Plugin\Assessment\Tests\Unit\AbstractUnitTestcase;
use Brain\Monkey\Expectation\Exception\Exception;
use Brain\Monkey\Functions;
use Plugin\Assessment\Services\UserDetail\UserDetailController;
use Plugin\Assessment\Services\UserDetail\UserDetailHandler;
use Plugin\Core\Services\Message\MessageController;

class UserDetailHandlerTest extends AbstractUnitTestcase
{
    /**
     * Tests that the handle function returns an error when no nonce is setup
     */
    public function testHandleReturnsErrorNonceNotSet()
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
        $controller = $this->createStub(UserDetailController::class);

        // Act
        $class = new UserDetailHandler($message, $controller);
        $class->handle();
    }

    /**
     * Tests that the handle function returns an error when the nonce is not set
     * FAILURE ROUTE
     */
    public function testHandleReturnsErrorIfNonceNotSet()
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

        $controller = $this->createStub(UserDetailController::class);

        // Act
        $class = new UserDetailHandler($message, $controller);
        $class->handle();
    }

    /**
     * Tests that the handle function returns an error when the nonce is invalid
     * FAILURE ROUTE
     */
    public function testHandleReturnsSecurityError()
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

        $controller = $this->createStub(UserDetailController::class);

        // Act
        $class = new UserDetailHandler($message, $controller);
        $class->handle();
    }

    /**
     * Tests that the handle function returns an error when the id is not set
     */
    public function testHandleReturnsErrorIfIDNotSet()
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

        $controller = $this->createStub(UserDetailController::class);

        // Act
        $class = new UserDetailHandler($message, $controller);
        $class->handle();
    }

    /**
     * Tests that the handle function returns an error when the controller throws an exception
     */
    public function testHandleReturnsErrorIfControllerThrowsException()
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

        // Act
        $class = new UserDetailHandler($message, $controller);
        $class->handle();
    }
}
