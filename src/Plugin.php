<?php

declare(strict_types=1);

namespace Plugin\Assessment;

use Plugin\Core\Abstractions\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    public const NAME = "inpsyde-assessment";
    public const VERSION = "1.0";

    public function defineConstants(): void
    {
        if (! defined('PLUGIN_ASSESSMENT_LANG')) {
            define('PLUGIN_ASSESSMENT_LANG', 'inpsyde-assessment');
        }
    }

    public function dependencies(): array
    {
        return [];
    }
}
