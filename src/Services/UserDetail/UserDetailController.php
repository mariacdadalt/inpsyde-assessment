<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserDetail;

use Plugin\Assessment\Abstractions\AssessmentController;

class UserDetailController extends AssessmentController
{
    protected UserDetailAPI $api;

    public function __construct(UserDetailAPI $api)
    {
        $this->api = $api;
        parent::__construct();
    }

    public function args(array $args = [])
    {
        $this->api->changeArgs($args);

        $args = [
            'user' => $this->api->requestGET($args),
        ];
        parent::args($args);
    }
}
