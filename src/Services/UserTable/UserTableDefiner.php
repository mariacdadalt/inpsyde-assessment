<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserTable;

use Plugin\Core\Abstractions\AbstractDefiner;

/**
 * This class defines Dependency Injection for the UserTable Classes
 */
class UserTableDefiner extends AbstractDefiner
{
    public function define(): array
    {

        return [
            UserTableAPI::class => \DI\autowire()->constructorParameter(
                'url',
                'https://jsonplaceholder.typicode.com/users'
            ),
        ];
    }
}
