<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\Instructors;

use App\Api\V1\ResultCode;

class DataRequestController implements ResultCode {
    
    public const FAIL_INVALID_AUTH_JWT = 1;
    private const MSG = [
        "Request Process Ok",
        "Invalid authentication"
    ];
    
    private static function loadData(): object {
        $file = dirname(__DIR__, 4) . "/instance/instructor-data.json" ;
        $json = file_get_contents($file);
        return json_decode($json);
    }
    
    private static function get(string $jwt, callable $success, callable $error) {
        $instructor = AuthController::getInstructor($jwt);
        
        if ($instructor == null) {
            $error(self::getResultMessage(self::FAIL_INVALID_AUTH_JWT));
            return;
        }
        $success(self::getResultMessage(self::RESULT_OK), self::loadData());
    }
    
    public static function put(string $jwt, $data, callable $success, callable $error ) {
        $instructor = AuthController::getInstructor($jwt);
    
        if ($instructor == null) {
            $error(self::getResultMessage(self::FAIL_INVALID_AUTH_JWT));
            return;
        }
        $file = dirname(__DIR__, 4) . "/instance/instructor-data.json" ;
        
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        $success(self::getResultMessage(self::RESULT_OK), self::loadData());
    }
    
    public static function process(string $requestMethod, array $inputs, callable $success, callable $error) {
        // TODO use an auth middleware
        switch ($requestMethod) {
            case "GET":
                self::get($inputs["jwt"], $success, $error);
                break;
            
            case "PUT":
                self::put($inputs["jwt"], $inputs["data"], $success, $error);
                break;
        }
    }
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
    
}
