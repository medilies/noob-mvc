<?php
/**
 * Get the required controller & its method from the URL
 */

namespace Core;

use Exception;

class Router_EXPERIMENTAL
{

    public function __construct()
    {

        $url = $this->getUrl();

        $controller_name = ucwords(strtolower($url[0]));
        $method_name = strtolower($url[1]);
        $params = $url[2];

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

            $controller_pattern = "(?<controller>[a-zA-Z0-9_]+)";
            $method_pattern = "(?<method>[a-zA-Z0-9_]+)";
            $params_pattern = "(?<params>.*)";
            $pattern = "$controller_pattern(\/$method_pattern(\/$params_pattern)*)?";
            $pattern = "/^$pattern$/";

            $url = rtrim($url, '/');
            preg_match($pattern, $url, $rout);

            if (!empty($rout['controller'])) {
                $controller_name = $rout['controller'];
            } else {
                trigger_error("No matching controller");
            }

            if (!empty($rout['method'])) {
                $method_name = $rout['method'];
            } else {
                $method_name = DEFAULT_URL_METHOD;
            }

            if (isset($rout['params'])) {
                $params = explode('/', $rout['params']);
            } else {
                $params = [];
            }

            return [$controller_name, $method_name, $params];

        } else {
            return [DEFAULT_URL_CONTROLLER, DEFAULT_URL_METHOD, []];
        }

    }
}
