# noob-mvc

A lightweight PHP MVC framework to develope webapps that uses PHP + MySQL and optionally run on DOCKER.
The framework is simple and easy to customise and assume some best practices for security.

File struture:

```sh
.
├───db
├───secrets
└───web
    ├───App
    │   ├───Controllers
    │   ├───Helpers
    │   ├───Models
    │   └───Views
    │       ├───inc
    │       └───pages
    ├───Core
    ├───logs
    ├───public
    │   ├───assets
    │   │   ├───fonts
    │   │   └───img
    │   ├───css
    │   └───js
    └───vendor
        └───composer
```

## Setup

### Composer

The framework uses composer to generate the PSR-4 autoloader

```JSON
"autoload": {
"psr-4": {
"Core\\": "Core/",
"App\\": "App/"
}
```

The PSR-4 autoloader relies on Namespaces & filestructure.

U may have to run the following **command**:

```sh
composer dump-autoload

```

### Docker

If you have no knowledge about docker just run the following command from the project root directory

```sh
docker-compose up
```

This will pull PHP8, MySQL8 & PHPMyAdmin for local dev environment.

#### Customizing docker stack

The project includes 2 docker-compose files

- docker-compose.yml for dev

- docker-compose-prod.yml for production (Adds a container for database backups)


The `/secrets` folder contains text files prefixed with with `DB_` set their content according to their names.
The idea of behind those files is to ensure the "least privilige users" security concept.

**NOTE:** The creation of the users is supposed to be automated. But till now I have no idea how to set a shell script as entrypoint 
or pass the values to docker-entrypoint-initdb.d sql file to do the users creation according to the secrets.
So you still need to rerwite the users names and password in `/db/db.sql` file


## Start coding

### URL

The URL is parsed as `/<controller_name>/<method_name>/<method_params>`

- If URL is `/` it will be substituted as `/default_url_controller/default_url_method`
- If URL is `/controller_name` it will be substitued as `/controller_name/default_url_method`
- The `method_params` are always optionnal

### Models-Controllers-Views

First create the controller file in `/web/App/Contreller/` and name it by the controller class name keeping case sensitivity in mind

```php
<?php
class Pages extends Core\Controller
{
    public function __construct()
    {
        $this->model = $this->model('Pages_model'); 
    }
    public function index()
    {
        $this->model->set_db_users(['SELECT', 'INSERT', 'UPDATE', 'DELETE']);
        $this->model->index();
        
        $data = [
            'title' => 'Home',
            'stylesheets_array' => [],
            'scripts_array' => [],
        ];
        \Core\View::render('/pages/home.php', $data);
    }
}
```

`model()` method will load the model class Pages_model which must exist in the file `/web/App/Models/Pages_model.php` :

```php
<?php

class Pages_model extends Core\Database

{
    public function index()
    {
    }
}
```

The method index will have the properties $Selector, $Deleter, $Updater, $Inserter to be used as PDO connections

`\Core\Vie::render()` echo the specified file from `/web/App/Views` and pass to it all specied data. `/pages/home.php` can be written as `pages/home`

**NOTE** mind checking `/web/App/View/inc/template.php` and cutomizing it

**EXTRA** mind customising `/web/App/Helpers/Access_control.php` and call it method at the beggining of controllers methods

