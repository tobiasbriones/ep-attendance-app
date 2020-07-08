<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\Instructors;

use App\Api\V1\ResultCode;

class DataRequestInput implements ResultCode {
    
    public const INVALID_REQUEST_METHOD = 1;
    public const NO_JWT_INPUT = 2;
    public const WRONG_INPUTS = 3;
    private const MSG = [
        "DataRequestInput Ok",
        "Invalid request method",
        "No JWT input",
        "Wrong input. Check the API documentation",
    ];
    
    private static function validateGetRequest(array $inputs): int {
        if (!isset($inputs["jwt"])) {
            return self::NO_JWT_INPUT;
        }
        return self::RESULT_OK;
    }
    
    private static function validatePutRequest(array $inputs): int {
        if (!isset($inputs["jwt"])) {
            return self::NO_JWT_INPUT;
        }
        if (!isset($inputs["data"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["data"]["name"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["data"]["activeCourse"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["data"]["activeCourse"]["name"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["data"]["activeCourse"]["startTime"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["data"]["activeCourse"]["endTime"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["data"]["activeCourse"]["link"])) {
            return self::WRONG_INPUTS;
        }
        return self::RESULT_OK;
    }
    
    public static function validate(string $requestMethod, array $inputs): int {
        switch ($requestMethod) {
            case "GET":
                $resultCode = self::validateGetRequest($inputs);
                break;
            case "PUT":
                $resultCode = self::validatePutRequest($inputs);
                break;
            default:
                $resultCode = self::INVALID_REQUEST_METHOD;
                break;
        }
        return $resultCode;
    }
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
    
}
