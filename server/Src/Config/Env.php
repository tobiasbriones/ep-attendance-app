<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Config;

use Dotenv\Dotenv;

class Env {
    
    public const JWT_KEY = "JWT_KEY";
    public const INSTRUCTOR_EMAIL_KEY = "INSTRUCTOR_EMAIL";
    public const INSTRUCTOR_PASSWORD_KEY = "INSTRUCTOR_PASSWORD";
    private static bool $isLoaded = false;
    
    public static function get($key): string {
        if (!Env::$isLoaded) {
            Dotenv::createImmutable(dirname(__DIR__, 2) )->load();
            Env::$isLoaded = true;
        }
        return $_ENV[$key];
    }
    
}
