<?php

namespace Core;

use Exception;

class Utility
{
    /**
     * $path starts with no slash
     */
    public static function redirect(string $path): void
    {
        if ($path[0] === "/") {
            $path = substr($path, 1);
        }

        $site_base_url = SITE_BASE_URL;
        header("Location: $site_base_url/$path");
    }

    /**
     * Copied from wordpress docker image getenv_docker()
     *
     * Look for variable in following order:
     * - secret file
     * - env_var
     * - function $default
     */
    public static function getenv(string $env, string $default = ""): string
    {

        $secret_file = "/run/secrets/" . strtoupper($env);
        $env_var = strtoupper($env);

        if (file_exists($secret_file)) {
            return file_get_contents($secret_file);

        } else if ($val = getenv($env_var)) {
            return $val;

        } else if (!empty($default)) {
            return $default;

        } else {
            throw new Exception("env_var/secret $env not fount and default isn't provided", 1);

        }
    }

    public static function is_in_open_basedir(string $path): bool
    {
        // not sure if realpath does all what's required
        return realpath($path);
    }
}
