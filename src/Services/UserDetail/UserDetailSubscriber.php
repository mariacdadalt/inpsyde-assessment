<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserDetail;

use Plugin\Core\Abstractions\AbstractSubscriber;
use Plugin\Core\Services\Modal\ModalController;
use Plugin\Core\Services\Loader\LoaderController;

/**
 * This class connects to WordPress.
 */
class UserDetailSubscriber extends AbstractSubscriber
{
        /**
     * Subscribes the methods to the relevant hook.
     */
    public function subscribe()
    {
        add_action('wp_footer', [ $this, 'renderModal']);
    }

    public function renderModal()
    {
        if (get_query_var('user-table')) {
            $modal = $this->container->make(ModalController::class);
            $loader = $this->container->make(LoaderController::class);
            echo $modal->render([ //phpcs:ignore
                'modalID' => 'user-detail',
                'title' => 'User Details',
                'dismissible' => true,
                'body' => $loader->render(),
            ]);
        }
    }
}
