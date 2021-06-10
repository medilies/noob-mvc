<?php

class Pages extends Core\Controller

{
    /**
     * @var mixed
     */
    private $model;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->model = $this->model('Pages_model');
        $this->model->set_db_users(['SELECT', 'INSERT', 'UPDATE', 'DELETE']);
    }

    public function index()
    {
        $data = [
            'title' => 'Home',
            'stylesheets_array' => [],
            'scripts_array' => [],
        ];
        \Core\View::render('/pages/home.php', $data);
    }

}
