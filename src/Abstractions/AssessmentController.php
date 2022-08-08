<?php

declare(strict_types=1);

namespace Plugin\Assessment\Abstractions;

use Plugin\Core\Classes\MustacheRenderer;
use Plugin\Core\Abstractions\AbstractController;

/**
 * Extends Abstract Controller passing the src folder of the plugin.
 * @package Plugin\Core\Classes
 */
abstract class AssessmentController extends AbstractController
{
    public function __construct()
    {

        parent::__construct(new MustacheRenderer(dirname(__DIR__)));
    }
}
