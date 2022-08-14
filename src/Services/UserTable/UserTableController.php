<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserTable;

use Plugin\Core\Abstractions\AbstractController;
use Plugin\Core\Abstractions\AbstractRenderer;

class UserTableController extends AbstractController
{
    protected UserTableAPI $api;

    public function __construct(AbstractRenderer $renderer, UserTableAPI $api)
    {
        $this->api = $api;
        parent::__construct($renderer);
    }

    public function args(array $args = [])
    {
        $args = [
            'users' => $this->api->requestGET(),
        ];
        parent::args($args);
    }
}
