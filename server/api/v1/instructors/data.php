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
use App\Api\V1\Instructors\DataRequestController;
use App\Api\V1\Instructors\DataRequestInput;

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, PUT, HEAD, OPTIONS");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Max-Age: 600");
header("Content-Type: application/json; charset=UTF-8");

$request_method = $_SERVER["REQUEST_METHOD"];
$accepted_methods = ["GET", "PUT"];

Cors::check($request_method);
RequestMethod::check($accepted_methods, $request_method);
take_request($request_method);

// ------------------------------  FUNCTIONS  ------------------------------- //

function getInputs($request_method) {
    switch ($request_method) {
        case "GET":
            return $_GET;
        case "PUT":
            return json_decode(file_get_contents("php://input"), true);
    }
    return [];
}

function take_request($request_method) {
    $inputs = getInputs($request_method);
    $input_result = DataRequestInput::validate($request_method, $inputs);
    $success = fn (string $message, object $data) => End::send(
        [
            "message" => $message,
            "data" => $data
        ]
    );
    $error = fn ($errorMessage) => End::error($errorMessage, 401);
    
    if ($input_result != DataRequestInput::RESULT_OK) {
        End::error(DataRequestInput::getResultMessage($input_result), 400);
        exit;
    }
    DataRequestController::process($request_method, $inputs, $success, $error);
}