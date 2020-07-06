<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\Instructors;

use App\Config\Env;
use App\Model\Instructor;

class InstructorsController {
    
    public static function login(Instructor $instructor, string $password, callable $success, callable $error) {
        $INSTRUCTOR_EMAIL = Env::get(Env::INSTRUCTOR_EMAIL_KEY);
        $INSTRUCTOR_PASSWORD = Env::get(Env::INSTRUCTOR_PASSWORD_KEY);
        
        if ($INSTRUCTOR_EMAIL != $instructor->getEmail() || $INSTRUCTOR_PASSWORD != $password) {
            $resultCode = ResultCode::FAIL_INVALID_LOGIN;
            
            $error(ResultCode::getMessage($resultCode));
            return;
        }
        $success(
            ResultCode::getMessage(ResultCode::RESPONSE_OK),
            $instructor,
            ""
        );
    }
    
}
