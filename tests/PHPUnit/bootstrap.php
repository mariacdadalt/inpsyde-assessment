<?php

declare(strict_types=1);

const EP_ROOT = '';

$vendor = dirname(dirname(dirname(__FILE__))) . '/vendor/';

require_once $vendor . 'autoload.php';
unset($vendor);
