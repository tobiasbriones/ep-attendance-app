<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\Instructors;

use App\Api\V1\ResultCode;
use App\Model\Instructor;
use App\Storage\InstructorStorage;

class InstructorsRequestInput implements ResultCode {
    
    public const INVALID_REQUEST_METHOD = 1;
    public const WRONG_INPUTS = 2;
    private const MSG = [
        "InstructorsRequestInput Ok",
        "Invalid request method",
        "Wrong input. Check the API documentation",
    ];
    
    private static function validatePutRequest(array $inputs): int {
        if (!isset($inputs["name"])) {
            return self::WRONG_INPUTS;
        }
        return self::RESULT_OK;
    }
    
    public static function validate(string $requestMethod, array $inputs): int {
        switch ($requestMethod) {
            case "GET":
                $resultCode = self::RESULT_OK;
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
    
    public static function getInstructor(array $inputs): Instructor {
        $instructor = InstructorStorage::loadProfile();
        return Instructor::fromJson($instructor->getEmail(), $inputs);
    }
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
    
}
