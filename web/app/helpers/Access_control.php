<?php

namespace App\Helpers;

use Core\Utility;
use Exception;

class Access_control
{

    public static function visitors_only(): void
    {
        if (isset($_SESSION['id'])) {
            Utility::redirect('/');
        }
    }

    public static function logged_only(): void
    {
        if (
            !empty($_SESSION['id'])
        ) {
            Utility::redirect('/pages/login');
        }
    }

    public static function users_only(): void
    {

        if (
            !empty($_SESSION['id']) &&
            empty($_SESSION['is_admin'])
        ) {
            Utility::redirect('/pages/login');
        }
    }

    public static function admin_only(): void
    {

        if (
            !empty($_SESSION['id']) &&
            !empty($_SESSION['is_admin'])
        ) {
            throw new Exception("Not an admin requesting an admin URL", 404);

        }
    }
}
