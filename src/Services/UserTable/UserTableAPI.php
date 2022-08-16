<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserTable;

use Plugin\Core\Abstractions\AbstractAPI;

class UserTableAPI extends AbstractAPI
{
    protected function treatResponseCode(int $code): bool
    {
        if (200 === $code) {
            return true;
        }

        return false;
    }

    protected function formatBody(string $body): array
    {
        $list = json_decode($body, true);
        $users = [];
        foreach ($list as $item) {
            $users[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'username' => $item['username'],
            ];
        }
        return $users;
    }

    protected function cacheKey(): string
    {

        return 'user-table';
    }
}
