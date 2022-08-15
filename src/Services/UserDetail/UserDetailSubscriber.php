<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserDetail;

use Plugin\Core\Abstractions\AbstractSubscriber;
use Plugin\Core\Services\Modal\ModalController;
use Plugin\Core\Services\Loader\LoaderController;
use Plugin\Core\Core;

/**
 * This class connects to WordPress.
 */
class UserDetailSubscriber extends AbstractSubscriber
{
    public const ENDPOINT = 'user-detail';
    public const NONCE = 'user-detail-nonce';
    /**
     * Subscribes the methods to the relevant hook.
     */
    public function subscribe()
    {
        add_action('wp_footer', [ $this, 'renderModal']);
        add_action('wp_ajax_' . $this::ENDPOINT, [ $this, 'endpoint']);
        add_action('wp_ajax_nopriv_' . $this::ENDPOINT, [ $this, 'endpoint']);
        add_filter(Core::FILTER_AJAX_OBJECT, [$this, 'ajaxValues']);
    }

    public function renderModal()
    {
        if (!get_query_var('user-table')) {
            return;
        }

        $modal = $this->container->make(ModalController::class);
        $loader = $this->container->make(LoaderController::class);
        echo $modal->render([ //phpcs:ignore
            'modalID' => 'user-detail',
            'title' => 'User Details',
            'dismissible' => true,
            'body' => $loader->render(), //phpcs:ignore
        ]);
    }

    public function ajaxValues($values): array
    {
        if (!get_query_var('user-table')) {
            return $values;
        }

        $values['nonce'] = wp_create_nonce($this::NONCE);
        $values['action'] = $this::ENDPOINT;
        return $values;
    }

    public function endpoint()
    {
    }
}
