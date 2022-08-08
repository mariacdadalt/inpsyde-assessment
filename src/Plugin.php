<?php

declare(strict_types=1);

namespace Plugin\Assessment;

use Plugin\Core\Abstractions\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    public function defineConstants(): void
    {
        if (! defined('PLUGIN_ASSESSMENT_DIR')) {
            define('PLUGIN_ASSESSMENT_DIR', WP_CONTENT_DIR . '/plugins/inpsyde-assessment/');
        }

        if (! defined('PLUGIN_ASSESSMENT_LANG')) {
            define('PLUGIN_ASSESSMENT_LANG', 'inpsyde-assessment');
        }
    }

    public function dependencies(): array
    {
        return [];
    }
}
