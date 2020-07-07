<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\ApiTools;

class End {
    
    /**
     * Sends a 200 HTTP response code and the given object.
     *
     * @param $response array associative array to send as a json response
     */
    public static function send(array $response) {
        http_response_code(200);
        echo json_encode($response);
    }
    
    /**
     * Sends the given response code and a message with the specified error.
     *
     * @param $msg           string message to send as a response
     * @param $response_code int HTTP response code
     * @param $about         array list of the names of the params related to this error
     */
    public static function error(string $msg, int $response_code, array $about = []) {
        http_response_code($response_code);
        echo json_encode(["message" => $msg, "about" => json_encode($about)]);
    }
    
}
