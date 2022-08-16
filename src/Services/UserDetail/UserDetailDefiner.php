<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserDetail;

use Plugin\Core\Abstractions\AbstractDefiner;

/**
 * This class defines Dependency Injection for the UserTable Classes
 */
class UserDetailDefiner extends AbstractDefiner
{
    public function define(): array
    {

        return [
            UserDetailAPI::class => \DI\autowire()->constructorParameter(
                'url',
                'https://jsonplaceholder.typicode.com/users'
            ),
        ];
    }
}
