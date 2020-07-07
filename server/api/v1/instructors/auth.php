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
header("Access-Control-Allow-Methods: GET, POST, HEAD, OPTIONS");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Max-Age: 600");
header("Content-Type: application/json; charset=UTF-8");

$request_method = $_SERVER["REQUEST_METHOD"];
$accepted_methods = ["POST"];

cors($request_method);
check_request_method($accepted_methods, $request_method);
check_input();
process();

// ------------------------------  FUNCTIONS  ------------------------------- //

function cors($request_method) {
    if ($request_method === "OPTIONS"){
        exit;
    }
}

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
    
    if (!isset($_POST["jwt"])) {
        $wrong();
        return false;
    }
    return true;
}

function process() {
    $jwt = $_POST["jwt"];
    $success = fn (string $message, Instructor $instructor) => End::send(
        [
            "message" => $message,
            "instructor" => $instructor,
        ]
    );
    $error = fn ($errorMessage) => End::error($errorMessage, 401);
    
    InstructorsController::authenticateJWT($jwt, $success, $error);
}
