<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\User_Table;

global $controller;

wp_head();

echo esc_html($controller->render());

wp_footer();
