<?php

error_reporting(E_ALL);

// session_start();

const WEB_ROOT = __DIR__;

define('ERROR_REPORTING', Core\Utility::getenv('ERROR_REPORTING', "1"));
set_error_handler("Core\\Error::errorHandler");
set_exception_handler('Core\\Error::exceptionHandler');

define('SITE_BASE_URL', get_site_base_url());

date_default_timezone_set(Core\Utility::getenv('TZ', 'Africa/Algiers'));

// -----------------

// DB: in case of not using env_var or secret
const FALLBACK_DB_SERVER = 'localhost';
const FALLBACK_DB_NAME = 'noob_mvc';
const FALLBACK_DB_USERNAME = 'root';
const FALLBACK_DB_PASS = 'root';

// -----------------

define('CONFIG', get_config());

// SEO
const DEFAULT_LANG = CONFIG['default_lang'];
const APP_NAME = CONFIG['app_title'];

// formatted as "controller/method" + every controller MUST have an index() method
const DEFAULT_URL_CONTROLLER = CONFIG['default_url_controller'];
const DEFAULT_URL_METHOD = CONFIG['default_url_method'];

function get_config()
{
    $json = file_get_contents(__DIR__ . "/config.json");
    return json_decode($json, true);
}

function get_site_base_url(): string
{
    $protocol = $_SERVER['REQUEST_SCHEME'];
    $host_name = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT']; // UNRELIABLE ???

    return "$protocol://$host_name:$port";
}
