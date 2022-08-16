<?php

declare(strict_types=1);

namespace Plugin\Assessment\Services\UserDetail;

use Plugin\Core\Abstractions\AbstractHandler;
use Plugin\Core\Services\Message\MessageController;

class UserDetailHandler extends AbstractHandler
{
    protected MessageController $message;
    protected UserDetailController $controller;

    public function __construct(MessageController $message, UserDetailController $controller)
    {
        $this->message = $message;
        $this->controller = $controller;
    }

    public function handle(): void
    {
        if (
            ! isset($_POST['nonce']) ||
            ! wp_verify_nonce($_POST['nonce'], UserDetailSubscriber::NONCE) //phpcs:ignore
        ) {
            wp_send_json_error($this->message->render([
                'type' => 'alert',
                'message' => 'There was an error in your request',
                'dismissible' => true,
            ]));
            return;
        }

        if (!isset($_POST['id'])) {
            wp_send_json_error($this->message->render([
                'type' => 'alert',
                'message' => 'The id provided is invalid',
                'dismissible' => true,
            ]));
            return;
        }

        $id = sanitize_key($_POST['id']);

        try {
            wp_send_json_success($this->controller->render([
                'id' => $id,
            ]));
            return;
        } catch (\Exception $exception) {
            wp_send_json_error($this->message->render([
                'type' => 'alert',
                'message' => 'There was an error retriving the user information',
                'dismissible' => true,
            ]));
            return;
        }
    }
}
