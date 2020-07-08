<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\Instructors;

use App\Api\V1\ResultCode;
use App\Config\Env;
use App\Model\Instructor;
use Firebase\JWT\JWT;

// For this app there's only one instructor with email and password hash
// registered in the .env file
class LoginController implements ResultCode {
    
    public const FAIL_INVALID_LOGIN_CREDENTIALS = 1;
    private const MSG = [
        "Instructors request handled successfully",
        "Invalid instructor email or password",
    ];
    
    public static function login(Instructor $instructor, string $password, callable $success, callable $error) {
        $INSTRUCTOR_EMAIL = Env::get(Env::INSTRUCTOR_EMAIL_KEY);
        $INSTRUCTOR_PASSWORD_HASH = Env::get(Env::INSTRUCTOR_PASSWORD_HASH_KEY);
        $jwtPayload = [
            "iss" => "",
            "aud" => "",
            "iat" => "",
            "nbf" => "",
            "data" => [
                "email" => $instructor->getEmail()
            ]
        ];
        
        if ($INSTRUCTOR_EMAIL != $instructor->getEmail() || !password_verify($password, $INSTRUCTOR_PASSWORD_HASH)) {
            $resultCode = self::FAIL_INVALID_LOGIN_CREDENTIALS;
            
            $error(self::getResultMessage($resultCode));
            return;
        }
        $success(
            self::getResultMessage(ResultCode::RESULT_OK),
            $instructor,
            JWT::encode($jwtPayload, Env::get(Env::JWT_KEY))
        );
    }
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
    
}
