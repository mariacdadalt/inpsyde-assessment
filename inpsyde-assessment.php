<?php

/**
 * Plugin Name: Maria C. Dadalt's Inpsyde Assessment
 * Plugin URI:
 * Description: A plugin build to assess coding ability.
 * Version: 1.0
 * Author: Maria C. Dadalt
 * Author URI:
 * License: MIT
 */

declare(strict_types=1);

use Plugin\Assessment\Plugin;

/**
 * Register the plugin instance with the Core Plugin.
 */
core()->registerPlugin(new Plugin());
