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
use Exception;

class InstructorsRequestController implements ResultCode {
    
    private const MSG = [
        "Request Process Ok",
    ];
    
    public static function get(callable $success, callable $error) {
        $profile = null;
        
        try {
            $profile = InstructorStorage::loadProfile();
        }
        catch (Exception $err) {
            $error("Fail to save instructor profile");
            return;
        }
        $success(self::getResultMessage(self::RESULT_OK), $profile);
    }
    
    public static function put(Instructor $instructor, callable $success, callable $error) {
        try {
            InstructorStorage::saveProfile($instructor);
        }
        catch (Exception $err) {
            $error("Fail to save instructor profile");
            return;
        }
        $success(self::getResultMessage(self::RESULT_OK), $instructor);
    }
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
    
}
