<?php

namespace App\Helpers;

class My
{
    /**
     * dump and die
     */
    public static function var_dump($var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }

    /**
     * dump and die
     */
    public static function dnd($var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die;
    }
}
