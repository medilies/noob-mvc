<?php

namespace Core;

use Exception;

class View
{

    /**
     * loads view HTML generation
     *
     * @param string $view_name
     * @param array $data dynamic part in the view
     * @throws Exception
     */
    public static function render(string $view_name, array $data = []): void
    {
        // extract starting slash & file extension
        preg_match("/^\/?(?<view_name>[a-zA-Z0-9\/_-]*)(\..*)?$/", $view_name, $match);

        $view_name = $match['view_name'];

        $view_path = WEB_ROOT . "/App/Views/$view_name.php";

        if (!file_exists($view_path)) {
            throw new Exception("Can't find the view file $view_path", 500);
        }

        require_once $view_path;
    }

}
