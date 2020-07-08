<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\ApiTools;

class Cors {
    
    public static function check(string $requestMethod) {
        if ($requestMethod === "OPTIONS"){
            exit;
        }
    }
    
}
