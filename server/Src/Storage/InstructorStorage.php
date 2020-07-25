<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Storage;

use App\Config\Env;
use App\Model\Course;
use App\Model\Instructor;

// Remember that for the system (api v1) there's only one instructor and only
// one course.
// It doesn't support more than one instructor and/or course according to its
// specification, it's just an example project
class InstructorStorage {
    
    private const PROFILE_KEY = "profile";
    private const ACTIVE_COURSE_KEY = "activeCourse";
    
    private static function saveData(array $data) {
        $file = dirname(__DIR__, 2) . "/storage/instructor-data.json";
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }
    
    private static function loadData(): array {
        $file = dirname(__DIR__, 2) . "/storage/instructor-data.json";
        return json_decode(file_get_contents($file), true);
    }
    
    public static function saveProfile(Instructor $instructor) {
        $instructorData = self::loadData();
        $instructorData[self::PROFILE_KEY] = $instructor->jsonSerialize();
        self::saveData($instructorData);
    }
    
    public static function loadProfile(): Instructor {
        $email = Env::get(Env::INSTRUCTOR_EMAIL_KEY);
        return Instructor::fromJson($email, self::loadData()[self::PROFILE_KEY]);
    }
    
    public static function saveActiveCourse(Course $course) {
        $instructorData = self::loadData();
        
        $instructorData[self::ACTIVE_COURSE_KEY] = $course->jsonSerialize();
        self::saveData($instructorData);
    }
    
    public static function loadActiveCourse(): Course {
        return Course::fromJson(self::loadData()[self::ACTIVE_COURSE_KEY]);
    }
    
}
