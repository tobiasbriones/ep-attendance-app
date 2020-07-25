<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V1\Instructors\Courses;

use App\Api\V1\ResultCode;
use App\Model\Course;
use App\Storage\InstructorStorage;
use Exception;

class CourseRequestController implements ResultCode {
    
    private const MSG = [
        "Request Process Ok",
    ];
    
    private static function loadData(): object {
        $file = dirname(__DIR__, 4) . "/instance/instructor-data.json";
        $json = file_get_contents($file);
        return json_decode($json);
    }
    
    public static function get(callable $success, callable $error) {
        $instructor = null;
        $course = null;
        
        try {
            $instructor = InstructorStorage::loadProfile();
            $course = InstructorStorage::loadActiveCourse();
        }
        catch (Exception $err) {
            $error("Fail to load course");
            return;
        }
        $success("Course loaded successfully", ["instructor" => $instructor, "course" => $course]);
    }
    
    public static function put(Course $course, callable $success, callable $error) {
        try {
            InstructorStorage::saveActiveCourse($course);
        }
        catch (Exception $err) {
            $error("Fail to save course: $course");
            return;
        }
        $success("Course updated successfully", $course);
    }
    
    public static function getResultMessage(int $resultCode): string {
        if ($resultCode < 0 || $resultCode >= count(self::MSG)) {
            return "Invalid result code. N/A";
        }
        return self::MSG[$resultCode];
    }
    
}
