<?php

declare(strict_types=1);

namespace Plugin\Assessment\Tests\Unit\Services\UserTable;

use Plugin\Assessment\Tests\Unit\AbstractUnitTestcase;
use Brain\Monkey\Filters;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use DI\Container;
use Plugin\Assessment\Services\UserTable\UserTableAPI;

class UserTableAPITest extends AbstractUnitTestcase
{
    /**
     * Tests if the treatResponseCode function returns true.
     * SUCCESS ROUTE
     */
    public function testTreatResponseCodeReturnsTrue()
    {
        // Arrange

        // Act
        $class = new UserTableAPI('');
        $result = $this->callMethod($class, 'treatResponseCode', [ 200 ]);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * Tests if the treatResponseCode function returns false.
     * FAILURE ROUTE
     */
    public function testTreatResponseCodeReturnsFalse()
    {
        // Arrange

        // Act
        $class = new UserTableAPI('');
        $result = $this->callMethod($class, 'treatResponseCode', [ 404 ]);

        // Assert
        $this->assertFalse($result);
    }
}
