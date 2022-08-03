<?php


namespace Plugin\Assessment\Abstractions;

use Plugin\Core\Classes\Mustache_Renderer;
use Plugin\Core\Abstractions\Abstract_Controller;

/**
 * Extends Abstract Controller passing the src folder of the plugin.
 * @package Plugin\Core\Classes
 */
abstract class Assessment_Controller extends Abstract_Controller
{
    public function __construct() {
        parent::__construct( new Mustache_Renderer( dirname(__DIR__ ) ) );
    }
}
