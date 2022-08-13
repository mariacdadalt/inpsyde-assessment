<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserTable;

use Plugin\Assessment\Abstractions\AssessmentController;

class UserTableController extends AssessmentController
{
    protected UserTableAPI $api;

    public function __construct(UserTableAPI $api)
    {
        $this->api = $api;
    }

    public function args(array $args = [])
    {

        $args['context'] = [
            'users' => $this->api->requestGET(),
        ];

        parent::args($args);
    }
}
