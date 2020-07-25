<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\Instructors\Courses;

use App\Api\V1\ResultCode;
use App\Model\Course;

class CourseRequestInput implements ResultCode {
    
    public const INVALID_REQUEST_METHOD = 1;
    public const WRONG_INPUTS = 2;
    public const WRONG_DAYS = 3;
    private const MSG = [
        "InstructorsRequestInput Ok",
        "Invalid request method",
        "Wrong input. Check the API documentation",
        "Wrong days, days is an array with values from 1 to 7 inclusive"
    ];
    
    private static function validatePutRequest(array $inputs): int {
        if (!isset($inputs["name"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["startTime"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["endTime"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["link"])) {
            return self::WRONG_INPUTS;
        }
        if (!isset($inputs["days"])) {
            return self::WRONG_INPUTS;
        }
        if (!is_array($inputs["days"])) {
            return self::WRONG_DAYS;
        }
        foreach ($inputs["days"] as $value) {
            if (!is_integer($value)) {
                return self::WRONG_DAYS;
            }
            if ($value < 1 || $value > 7) {
                return self::WRONG_DAYS;
            }
        }
        return self::RESULT_OK;
    }
    
    // This is probably temporary as I'm experimenting with pure PHP API design
    public static function getCourse(array $inputs): Course {
        return new Course(
            $inputs["name"],
            $inputs["startTime"],
            $inputs["endTime"],
            $inputs["link"],
            $inputs["days"]
        );
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
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
    
}
