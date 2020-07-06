<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

require_once "../../../vendor/autoload.php";

use App\Api\V1\ApiTools\End;
use App\Api\V1\Instructors\InstructorsController;
use App\Model\Instructor;


header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, HEAD");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 600");
header("Content-Type: application/json; charset=UTF-8");

$request_method = $_SERVER["REQUEST_METHOD"];
$accepted_methods = ["GET", "POST", "HEAD"];

check_request_method($accepted_methods, $request_method);
check_input();
process();

/*
 * Use this line of code to generate your instructor hashed password
 * echo password_hash("password", PASSWORD_BCRYPT);
 */

// ------------------------------  FUNCTIONS  ------------------------------- //

function check_request_method($accepted_methods, $request_method) {
    if (!in_array($request_method, $accepted_methods)) {
        End::error("Invalid request. Method not Allowed.", 405);
        exit;
    }
    return true;
}

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
            "Message" => $message,
            "Instructor" => json_encode($instructor),
            "JWT" => $jwt
        ]
    );
    $error = fn ($errorMessage) => End::error($errorMessage, 401);
    
    InstructorsController::login($instructor, $password, $success, $error);
}

// Authentication functionality
function check_auth_input() {
    $wrong = function () {
        $msg = "Wrong arguments or number of arguments. Check the API documentation";
        
        End::error($msg, 400);
        exit;
    };
    
    if (!isset($_POST["jwt"])) {
        $wrong();
        return false;
    }
    return true;
}

function accessWithJWT() {
    $jwt = $_POST["jwt"];
    $success = fn (string $message, Instructor $instructor) => End::send(
        [
            "Message" => $message,
            "Instructor" => json_encode($instructor),
        ]
    );
    $error = fn ($errorMessage) => End::error($errorMessage, 401);
    
    InstructorsController::authenticateJWT($jwt, $success, $error);
}
