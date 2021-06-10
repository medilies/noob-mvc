<?php
/**
 * Get the required controller & its method from the URL
 */

namespace Core;

use Exception;

class Router
{

    public function __construct()
    {

        $url = $this->getUrl();

        $controller_name = ucwords(strtolower($url[0]));
        $method_name = strtolower($url[1]);
        $params = array_slice($url, 2);

        $controller_file = WEB_ROOT . "/App/Controllers/$controller_name.php";

        if (!file_exists($controller_file)) {
            throw new Exception("Wrong URL controller: {$_GET['url']}", 404);
        }

        require_once $controller_file;
        $actual_controller = new $controller_name;

        if (!is_callable([$actual_controller, $method_name])) {
            throw new Exception("Wrong URL method: {$_GET['url']}", 404);
        }

        call_user_func_array([$actual_controller, $method_name], $params);
    }

    /**
     * MUST return an array
     *
     * formatted as:
     *
     * - ['controller','method']
     * - ['controller','method','params ...']
     */
    private function getUrl(): array
    {
        /**
         * $_GET['url'] can be:
         * - NULL
         * - controller
         * - controller/method
         * - controller/method/params...
         */

        if (!empty($_GET['url'])) {

            $url = $_GET['url'];

            $url = trim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);

            $url = explode('/', $url);

            // Only $url[0] => CONTROLLER
            if (empty($url[1])) {
                $url[1] = DEFAULT_URL_METHOD;
            }

            return $url;

        } else {
            return [DEFAULT_URL_CONTROLLER, DEFAULT_URL_METHOD];
        }

    }

}
