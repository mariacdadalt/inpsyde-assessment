<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserTable;

use Plugin\Core\Abstractions\AbstractSubscriber;

/**
 * The classes that extends this will hook with WordPress.
 */
class UserTableSubscriber extends AbstractSubscriber
{
    public function subscribe()
    {
        add_action('init', static function () {
            add_rewrite_endpoint('user-table', EP_ROOT);
        });

        add_filter('request', static function ($vars) {
            if (isset($vars['user-table'])) {
                $vars['user-table'] = true;
            }
            return $vars;
        });

        add_filter('template_include', function ($template) {
            if (get_query_var('user-table')) {
                global $controller;
                $controller = $this->container->get(UserTableController::class);
                return __DIR__ . '/UserTableTemplate.php';
            }
            return $template;
        }, 99);
    }
}
