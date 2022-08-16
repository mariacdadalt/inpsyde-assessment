<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserDetail;

use Plugin\Core\Abstractions\AbstractController;
use Plugin\Core\Abstractions\AbstractRenderer;

class UserDetailController extends AbstractController
{
    protected UserDetailAPI $api;

    public function __construct(AbstractRenderer $renderer, UserDetailAPI $api)
    {
        $this->api = $api;
        parent::__construct($renderer);
    }

    public function args(array $args = [])
    {
        $args = [
            'user' => $this->api->requestGET($args),
        ];
        parent::args($args);
    }
}
