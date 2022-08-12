<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserTable;

use Plugin\Core\Abstractions\AbstractSubscriber;

/**
 * The classes that extends this will hook with WordPress.
 */
class UserTableSubscriber extends AbstractSubscriber
{
    /**
     * Subscribes the methods to the relevant hook.
     */
    public function subscribe()
    {
        add_action('init', [ $this, 'addEndpoint' ]);
        add_filter('request', [ $this, 'addQueryVar']);
        add_filter('template_include', [ $this, 'interceptTemplate'], 99);
    }

    /**
     * Creates the user-table endpoint in the root domain.
     */
    public function addEndpoint(): void
    {
        add_rewrite_endpoint('user-table', EP_ROOT);
    }

    /**
     * Ensures that the user-table query var is set to true
     * once we visit domain/user-table/
     * @param array $vars
     * @return array
     */
    public function addQueryVar(array $vars): array
    {
        if (isset($vars['user-table'])) {
            $vars['user-table'] = true;
        }
        return $vars;
    }

    /**
     * When the query-var user-table is set, it will intercept template
     * and return the UserTableTemplate
     * @param string $template
     * @return string
     */
    public function interceptTemplate(string $template): string
    {
        if (get_query_var('user-table')) {
            global $controller;
            $controller = $this->container->get(UserTableController::class);
            return __DIR__ . '/UserTableTemplate.php';
        }
        return $template;
    }
}
