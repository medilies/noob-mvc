<?php
/**
 * Main file
 */

/**
 * Composer ps-4 autoloader
 * - composer.json : "ps-4"."autoload"."namespace":"rel_path"
 * - > composer dump-autoloader
 */
require_once '../vendor/autoload.php';

require_once '../config.php';

new Core\Router;
