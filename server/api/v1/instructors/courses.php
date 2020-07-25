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
use App\Api\V1\Instructors\AuthController;
use App\Api\V1\Instructors\Courses\CourseRequestController;
use App\Api\V1\Instructors\Courses\CourseRequestInput;
use App\Model\Course;
use App\Model\Instructor;

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, PUT, HEAD, OPTIONS");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Max-Age: 600");
header("Content-Type: application/json; charset=UTF-8");

// I'm still experimenting with RESTful APIs in PHP yet to find the way to go

$request_method = $_SERVER["REQUEST_METHOD"];
$accepted_methods = ["GET", "PUT"];
$instructorJWT = "";

// Check for authorization
if ($request_method == "PUT") {
    if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
        End::error("Unauthorized", 401);
        exit;
    }
    
    // Auth header looks like: 'Bearer <jwt>'
    $http_auth = $_SERVER["HTTP_AUTHORIZATION"];
    $split = preg_split("/\s+/", $http_auth);
    
    if (!$split) {
        End::error("Invalid authentication", 401);
        exit;
    }
    $instructorJWT = $split[1];
}

Cors::check($request_method);
RequestMethod::check($accepted_methods, $request_method);
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
    $input_result = CourseRequestInput::validate($request_method, $inputs);
    $errorUnauthorized = fn ($errorMessage) => End::error($errorMessage, 401);
    $error = fn ($errorMessage) => End::error($errorMessage, 500);
    
    if ($input_result != CourseRequestInput::RESULT_OK) {
        End::error(CourseRequestInput::getResultMessage($input_result), 400);
        exit;
    }
    
    if ($request_method == "GET") {
        CourseRequestController::get(
            fn (string $message, array $data) => End::send(
                [
                    "message" => $message,
                    "data" => $data
                ]
            ),
            $error
        );
    }
    else if ($request_method == "PUT") {
        $course = CourseRequestInput::getCourse($inputs);
        
        // Using callback hell middleware for now
        AuthController::authenticateJWT(
            $instructorJWT,
            fn (string $msg, Instructor $instructor) => CourseRequestController::put(
                $course,
                fn (string $message, Course $course) => End::send(
                    [
                        "message" => $message,
                        "data" => $course
                    ]
                ),
                $error
            ),
            fn ($errorMsg) => $errorUnauthorized($errorMsg)
        );
    }
}
