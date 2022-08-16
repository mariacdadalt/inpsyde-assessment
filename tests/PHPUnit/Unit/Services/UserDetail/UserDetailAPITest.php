<?php

declare(strict_types=1);

namespace Plugin\Assessment\Tests\Unit\Services\UserDetail;

use Plugin\Assessment\Tests\Unit\AbstractUnitTestcase;
use Plugin\Assessment\Services\UserDetail\UserDetailAPI;

class UserDetailAPITest extends AbstractUnitTestcase
{
    /**
     * Tests if the treatResponseCode function returns true.
     * SUCCESS ROUTE
     */
    public function testTreatResponseCodeReturnsTrue()
    {
        // Arrange

        // Act
        $class = new UserDetailAPI('');
        $result = $this->callMethod($class, 'treatResponseCode', [ 200 ]);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * Tests if the treatResponseCode function throws exception.
     * FAILURE ROUTE
     */
    public function testTreatResponseCodeThrowsException()
    {
        // Assert
        $this->expectException('Exception');

        // Arrange

        // Act
        $class = new UserDetailAPI('');
        $this->callMethod($class, 'treatResponseCode', [ 404 ]);
    }

     /**
     * Tests if the formatBody function returns a formatted array.
     * SUCCESS ROUTE
     */
    public function testFormatBodyReturnsFormattedArray()
    {
        // Arrange
        $body = file_get_contents(__DIR__ . '/_data/data.json');
        $expected = [
            'id' => 1,
            'name' => 'Leanne Graham',
            'username' => 'Bret',
            'email' => 'Sincere@april.biz',
            'address' => [
                'street' => 'Kulas Light',
                'suite' => 'Apt. 556',
                'city' => 'Gwenborough',
                'zipcode' => '92998-3874',
                'geo' => [
                    'lat' => '-37.3159',
                    'lng' => '81.1496',
                ],
            ],
            'phone' => '1-770-736-8031 x56442',
            'website' => 'hildegard.org',
            'company' => [
                'name' => 'Romaguera-Crona',
                'catchPhrase' => 'Multi-layered client-server neural-net',
                'bs' => 'harness real-time e-markets',
            ],
        ];

        // Act
        $class = new UserDetailAPI('');
        $result = $this->callMethod($class, 'formatBody', [ $body ]);

        // Assert
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests if the parseUrl function returns a formatted string.
     * SUCCESS ROUTE
     */
    public function testParseUrlReturnsCorrectUrl()
    {
        // Arrange
        $url = 'the-url.com/users';
        $args = [
            'id' => 1,
        ];

        // Act
        $class = new UserDetailAPI($url);
        $result = $this->callMethod($class, 'parseUrl', [ $args ]);

        // Assert
        $this->assertEquals('the-url.com/users/1', $result);
    }
}
