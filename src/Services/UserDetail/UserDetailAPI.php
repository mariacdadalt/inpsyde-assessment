<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserDetail;

use Exception;
use Plugin\Core\Abstractions\AbstractAPI;

class UserDetailAPI extends AbstractAPI
{
    protected function treatResponseCode(int $code): bool
    {
        if (200 === $code) {
            return true;
        }

        throw new Exception('An error has ocurred while retriving the data', $code);
    }

    protected function formatBody(string $body): array
    {
        return json_decode($body, true);
    }

    protected function parseUrl(array $args): string
    {
        if (!isset($args['id'])) {
            return $this->url;
        }

        return $this->url . '/' . $args['id'];
    }
}
