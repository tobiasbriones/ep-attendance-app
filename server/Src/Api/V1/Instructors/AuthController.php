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
use Exception;
use Firebase\JWT\JWT;

class AuthController implements ResultCode {
    
    public const FAIL_INVALID_AUTH_JWT = 1;
    private const MSG = [
        "Instructors authentication handled successfully",
        "Invalid login credentials"
    ];
    
    static function getInstructor(string $jwt): ?Instructor {
        try {
            $decodedJWT = JWT::decode($jwt, Env::get(Env::JWT_KEY), ["HS256"]);
            return new Instructor($decodedJWT->data->email);
        }
        catch (Exception $e) {
            return null;
        }
    }
    
    public static function authenticateJWT(string $jwt, callable $success, callable $error) {
        $accessDenied = function () use ($error) {
            $resultCode = self::FAIL_INVALID_AUTH_JWT;
            
            $error(self::getResultMessage($resultCode));
        };
        $instructor = self::getInstructor($jwt);
        
        if ($instructor == null) {
            $accessDenied();
            return;
        }
        
        $success(
            self::getResultMessage(ResultCode::RESULT_OK),
            $instructor
        );
    }
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
}
