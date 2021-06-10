<?php
/*
 * Base Controller
 * Loads the models and views
 */

namespace Core;

use Exception;

class Controller
{
    /**
     * loads model for database use
     *
     * @param string $model name of Class and its file
     * @throws Exception
     */
    protected function model(string $model)
    {
        $model_path = WEB_ROOT . "/App/Models/$model.php";

        if (!file_exists($model_path)) {
            throw new Exception("Model $model_path does not exist", 500);
        }

        require_once $model_path;
        return new $model();
    }

}
