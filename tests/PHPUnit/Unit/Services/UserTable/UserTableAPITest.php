<?php

declare(strict_types=1);

namespace Plugin\Assessment\Tests\Unit\Services\UserTable;

use Plugin\Assessment\Tests\Unit\AbstractUnitTestcase;
use Plugin\Assessment\Services\UserTable\UserTableAPI;

use function Brain\Monkey\Functions\when;
use function PHPUnit\Framework\assertIsArray;

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

    public function testFormatBodyReturnsFormattedArray()
    {
        // Arrange
        $body = file_get_contents(__DIR__ . '/_data.json');
        $expected = [
            [
                'id' => 1,
                'name' => 'Leanne Graham',
                'username' => 'Bret',
            ],
            [
                'id' => 2,
                'name' => 'Ervin Howell',
                'username' => 'Antonette',
            ],
            [
                'id' => 3,
                'name' => 'Clementine Bauch',
                'username' => 'Samantha',
            ],
        ];

        // Act
        $class = new UserTableAPI('');
        $result = $this->callMethod($class, 'formatBody', [ $body ]);

        // Assert
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }
}
