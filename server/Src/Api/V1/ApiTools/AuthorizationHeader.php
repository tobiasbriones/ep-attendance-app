<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\ApiTools;

class AuthorizationHeader {
    
    /**
     * Returns the jwt if it is in the authorization header.
     * If the jwt is not found then it ends with 401.
     *
     * @return string the jwt provided it is in the authorization header
     */
    public static function getJWT(): string {
        if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
            End::error("Unauthorized", 401);
            exit;
        }
        
        // Auth header looks like: 'Bearer <jwt>'
        $http_auth = $_SERVER["HTTP_AUTHORIZATION"];
        $split = preg_split("/\s+/", $http_auth);
        
        if (!$split || !isset($split[1])) {
            End::error("Invalid authentication", 401);
            exit;
        }
        return $split[1];
    }
    
}
