<?php

error_reporting(E_ALL);

// session_start();

const WEB_ROOT = __DIR__;

define('ERROR_REPORTING', Core\Utility::getenv('ERROR_REPORTING', "1"));
set_error_handler("Core\\Error::errorHandler");
set_exception_handler('Core\\Error::exceptionHandler');

define('SITE_BASE_URL', get_site_base_url());

// -----------------

define('CONFIG', get_config());

date_default_timezone_set(Core\Utility::getenv('TZ', CONFIG['timezone']));

// URL
const DEFAULT_URL_CONTROLLER = CONFIG['default_url_controller'];
const DEFAULT_URL_METHOD = CONFIG['default_url_method'];

// DB
const DB_PDO_DRIVER = CONFIG['db']['db_driver'] ?? 'mysql'; // or 'pgsql'
const FALLBACK_DB_SERVER = CONFIG['db']['fallback_db_server'] ?? 'localhost';
const FALLBACK_DB_NAME = CONFIG['db']['fallback_db_name'] ?? 'db';
const FALLBACK_DB_PORT = CONFIG['db']['fallback_db_port'] ?? 3306;
const FALLBACK_DB_USERNAME = CONFIG['db']['fallback_db_username'] ?? 'root';
const FALLBACK_DB_PASS = CONFIG['db']['fallback_db_pass'] ?? '';
const ATTR_PERSISTENT = CONFIG['db']['attr_persistent'] ?? false;
const ATTR_EMULATE_PREPARES = CONFIG['db']['attr_emulate_prepares'] ?? true;
const ATTR_STRINGIFY_FETCHES = CONFIG['db']['attr_stringify_fetches'] ?? true;

// SEO
const DEFAULT_LANG = CONFIG['default_lang'];
const APP_NAME = CONFIG['app_title'];

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
