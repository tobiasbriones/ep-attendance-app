<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

require_once "../../../vendor/autoload.php";

use App\Api\V1\ApiTools\Cors;
use App\Api\V1\ApiTools\End;
use App\Api\V1\ApiTools\RequestMethod;
use App\Api\V1\Instructors\LoginController;
use App\Model\Instructor;

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, HEAD, OPTIONS");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Max-Age: 600");
header("Content-Type: application/json; charset=UTF-8");

$request_method = $_SERVER["REQUEST_METHOD"];
$accepted_methods = ["POST"];

Cors::check($request_method);
RequestMethod::check($accepted_methods, $request_method);
check_input();
process();

/*
 * Use this line of code to generate your instructor hashed password
 * echo password_hash("password", PASSWORD_BCRYPT);
 */

// ------------------------------  FUNCTIONS  ------------------------------- //

function check_input() {
    $wrong = function () {
        $msg = "Wrong arguments or number of arguments. Check the API documentation";
        
        End::error($msg, 400);
        exit;
    };
    $params_set = true;
    $params_set &= isset($_POST["email"]);
    $params_set &= isset($_POST["password"]);
    
    if (!$params_set) {
        $wrong();
        return false;
    }
    return true;
}

function process() {
    $instructor = new Instructor($_POST["email"]);
    $password = $_POST["password"];
    $success = fn (string $message, Instructor $instructor, string $jwt) => End::send(
        [
            "message" => $message,
            "instructor" => $instructor,
            "jwt" => $jwt
        ]
    );
    $error = fn ($errorMessage) => End::error($errorMessage, 401);
    
    LoginController::login($instructor, $password, $success, $error);
}
