<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

require_once "../../../vendor/autoload.php";

use App\Api\V1\ApiTools\AuthorizationHeader;
use App\Api\V1\ApiTools\Cors;
use App\Api\V1\ApiTools\End;
use App\Api\V1\ApiTools\RequestMethod;
use App\Api\V1\Instructors\AuthController;
use App\Api\V1\Instructors\InstructorsRequestController;
use App\Api\V1\Instructors\InstructorsRequestInput;
use App\Model\Instructor;

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, PUT, HEAD, OPTIONS");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Max-Age: 600");
header("Content-Type: application/json; charset=UTF-8");

$request_method = $_SERVER["REQUEST_METHOD"];
$accepted_methods = ["GET", "PUT"];

Cors::check($request_method);
RequestMethod::check($accepted_methods, $request_method);

$instructorJWT = AuthorizationHeader::getJWT();

take_request($request_method, $instructorJWT);

// ------------------------------  FUNCTIONS  ------------------------------- //

function getInputs($request_method) {
    $inputs = null;
    
    switch ($request_method) {
        case "GET":
            $inputs = $_GET;
            break;
        case "PUT":
            $inputs = json_decode(file_get_contents("php://input"), true);
            break;
    }
    return isset($inputs) ? $inputs : [];
}

function take_request($request_method, $instructorJWT) {
    $inputs = getInputs($request_method);
    $input_result = InstructorsRequestInput::validate($request_method, $inputs);
    $success = fn (string $message, Instructor $instructor) => End::send(
        [
            "message" => $message,
            "data" => $instructor
        ]
    );
    $errorUnauthorized = fn ($errorMessage) => End::error($errorMessage, 401);
    $error = fn ($errorMessage) => End::error($errorMessage, 500);
    
    if ($input_result != InstructorsRequestInput::RESULT_OK) {
        End::error(InstructorsRequestInput::getResultMessage($input_result), 400);
        exit;
    }
    
    // Using callback hell middleware for now
    AuthController::authenticateJWT(
        $instructorJWT,
        function (string $msg, Instructor $validated) use ($request_method, $success, $error, $inputs) {
            if ($request_method == "GET") {
                InstructorsRequestController::get($success, $error);
            }
            else if ($request_method == "PUT") {
                $instructor = InstructorsRequestInput::getInstructor($inputs);
                
                InstructorsRequestController::put($instructor, $success, $error);
            }
        },
        fn ($errorMsg) => $errorUnauthorized($errorMsg)
    );
}
