<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserTable;

use Plugin\Assessment\Abstractions\AssessmentController;

class UserTableController extends AssessmentController
{
    public function args(array $args = [])
    {

        $args['context'] = [
        ];

        parent::args($args);
    }
}
