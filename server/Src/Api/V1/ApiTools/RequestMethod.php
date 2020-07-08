<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\ApiTools;

class RequestMethod {
    
    /**
     * Checks whether the given request method is allowed according with the
     * passed allowed methods list. It calls <code>End::error</code> and then
     * <code>exit</code> if it fails to check the method.
     *
     * @param $allowedMethods array array containing the allowed methods
     * @param $requestMethod  string request method to evaluate
     *
     * @return bool <code>true</code> when the method is allowed
     */
    public static function check(array $allowedMethods, string $requestMethod) {
        if (!in_array($requestMethod, $allowedMethods)) {
            End::error("Invalid request. Method not Allowed.", 405);
            exit;
        }
        return true;
    }
    
}
