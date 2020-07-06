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
use Exception;
use Firebase\JWT\JWT;

// For this app there's only one instructor with email and password hash
// registered in the .env file
class InstructorsController {
    
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
            $resultCode = ResultCode::FAIL_INVALID_LOGIN_CREDENTIALS;
            
            $error(ResultCode::getMessage($resultCode));
            return;
        }
        $success(
            ResultCode::getMessage(ResultCode::RESULT_OK),
            $instructor,
            JWT::encode($jwtPayload, Env::get(Env::JWT_KEY))
        );
    }
    
    public static function authenticateJWT(string $jwt, callable $success, callable $error) {
        $accessDenied = function () use ($error) {
            $resultCode = ResultCode::FAIL_INVALID_AUTH_JWT;
            
            $error(ResultCode::getMessage($resultCode));
        };
        $instructor = null;
        
        try {
            $decodedJWT = JWT::decode($jwt, Env::get(Env::JWT_KEY), ["HS256"]);
            $instructor = new Instructor($decodedJWT->data->email);
        }
        catch (Exception $e) {
            $accessDenied();
            return;
        }
        
        $success(
            ResultCode::getMessage(ResultCode::RESULT_OK),
            $instructor
        );
    }
    
}
