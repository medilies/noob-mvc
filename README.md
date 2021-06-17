# noob-mvc

A lightweight PHP MVC framework to develope webapps that uses PHP + MySQL and optionally run on DOCKER.
The framework is simple and easy to customise and assume some best practices for security.

File struture:

```sh
.
├───backups
├───db
├───secrets
└───web
    ├───App
    │   ├───Controllers
    │   ├───Helpers
    │   ├───Models
    │   └───Views
    ├───Core
    ├───logs
    ├───public
    │   ├───assets
    │   ├───img
    │   ├───css
    │   └───js
    └───vendor
```

## Setup

### Composer

The framework uses composer to generate the PSR-4 autoloader

The PSR-4 autoloader relies on Namespaces & filestructure.

```JSON
"autoload": {
"psr-4": {
"Core\\": "Core/",
"App\\": "App/"
}
```

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
Then you can edit the PHP code directly in the `/web` folder because that folder is mounted from your main OS to the docker web service.

#### Customizing docker stack

The project includes 2 docker-compose files

-   docker-compose.yml for dev

-   docker-compose-prod.yml for production (Adds a service for daily database backups and doesn't mount the `/web` folder)

The `/secrets` folder contains text files prefixed with with `DB_` set their content according to their names.
The idea of behind having many users files is to ensure the "least privilige users" security concept.

**NOTE:** The creation of the users is supposed to be automated. But till now I have no idea how to set a shell script as entrypoint
or pass the values to docker-entrypoint-initdb.d sql file to do the users creation according to the secrets.
So you still need to rerwite the users names and password in `/db/db.sql` file

## Web service config

The Framework config is mainly done inside `/web/config.json`. The JSON file will get parsed in `/web/config.php` and turned to PHP constants during runtime.

### Config precedence

The framwork check for the config keys in the following order:

-   Docker secrets (`/run/secretes` folder).
-   Environement variable
-   Defaults and fallback values provided in `config.json`.

You may likely need to change only **app_title** & **default_lang** inside the JSON.

### URL

The URL is parsed as `/<controller_name>/<method_name>/<method_params>`

-   If URL is `/` it will be substituted as `/DEFAULT_URL_CONTROLLER/DEFAULT_URL_METHOD`
-   If URL is `/controller_name` it will be substitued as `/controller_name/DEFAULT_URL_METHOD`
-   The `method_params` are always optionnal

### DB

If you do not use docker secrets to specify the **database name**, **server name**, **port number** and **users credentials** you do one of the following

-   You can set environment variables in your hosting system according to the secrets files names and content.
-   Set user credentials in the config JSON. The user must have CRUD priviliges on the DB.
-   Edit the `Utility::getenv()` second arg in `/web/Core/Database.php`.

### ERROR_REPORTING

-   Set it to **1** during _dev_ to display error.
-   Set it to **0** in _production_ to write error error in `/web/logs` and show custom HTML pages for users.

#### TIMEZONE

Timezone can be set either as `TZ` environment variable or inside the JSON file;

## Start coding

### Controllers

Let's say you want to create a controller called **Pages**

-   First create the file `/web/App/Contrellers/Pages.php`, keeping case sensitivity in mind!
-   Then create the skelleton of your cotroller class as the following:

```php
<?php
class Pages extends Core\Controller
{
    public function index()
    {
        // Instantiating the model
        $this->model = $this->model('Pages_model');
        // CRUD priviliges you want yo use in the model
        $this->model->set_db_users(['SELECT', 'INSERT', 'UPDATE', 'DELETE']);
        // Calling the model method
        $this->model->index();
        // Preparing the dynamic data to pass to the view
        $data = [
            'title' => 'Home',
            'stylesheets_array' => [],
            'scripts_array' => [],
            'other_data' => null
        ];
        // echo the HTML page
        \Core\View::render('/pages/home.php', $data);
    }
}
```

### Models

Let's say you want to create a controller called **Pages_model**

-   First create the file `/web/App/Models/Pages_model.php`, keeping case sensitivity in mind!
-   Then create the skelleton of your model class as the following:

```php
<?php

class Pages_model extends Core\Database
{
    // The model object will have his PDO connections set in the controller after the intaniation
    public function index()
    {
        // Use directly Selector, Inserter, Deleter or Updater as PDO connections
        $select_query = "Select * FROM test Where id=:id";
        $data = $this->Selector->prepare($select_query);
        $this->data->bindParam(':id', 1, PDO::PARAM_INT);
        $this->data->execute();
        $data = $data->fetch();

        if($data->rowCount()){
            return $data;
        } else {
            echo "no data";
        }
    }
}
```

### Views

First and as a best practice it is recommended to put the head/footer of all pages in separate files and include them in pages files.
The framework proposes the following way of refactoring the header and the footer in `/web/App/Views/inc/layout.php`

```php
<!DOCTYPE html>
<html lang="<?=DEFAULT_LANG?>">
<head>
    <meta charset="UTF-8">

    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="/css/style.css">

    <?php if (!empty($data['stylesheets_array'])): ?>
        <?php foreach ($data['stylesheets_array'] as $stylesheet_name): ?>
            <link rel="stylesheet" href="/css/<?=$stylesheet_name?>.css">
        <?php endforeach;?>
    <?php endif;?>

    <?php if (!empty($data['title'])): ?>
        <title> <?=APP_NAME . ' | ' . $data['title']?>  </title>
    <?php else: ?>
        <title> <?=APP_NAME?>  </title>
    <?php endif;?>

</head>
<body>

    <nav>
    </nav>

    <main>
        <!-- The page content goes here-->
        <?=$content?>
    </main>

    <footer>
        Copyright <i class="fal fa-copyright" ></i> 2021
    </footer>

</body>

<!-- SCRIPTS -->
<?php if (!empty($data['scripts_array'])): ?>
    <?php foreach ($data['scripts_array'] as $script_name): ?>
        <script src="/js/<?=$script_name?>.js"></script>
    <?php endforeach;?>
<?php endif;?>
</html>
```

Now lets say we have `\Core\View::render('pages/home', $data)` The method will echo the content of the page `/web/App/Views/pages/home.php`

```php
<?php ob_start();?>

The page Home main body goes here

<?php $content = ob_get_clean();?>
<?php require_once WEB_ROOT . '/App/Views/inc/layout.php';?>
```

### Access control

**EXTRA:** mind customising `/web/App/Helpers/Access_control.php` and call its methods at the beggining of the controllers methods.

### Add your own classes

Feel free to add folders and classes files in the `/App` folder just spicify the correct namespace for your new classes

### Credit

The realisation of this project is highly influenced by what I learned from these two courses

- https://www.udemy.com/course/php-mvc-from-scratch/
- https://www.udemy.com/course/object-oriented-php-mvc/
