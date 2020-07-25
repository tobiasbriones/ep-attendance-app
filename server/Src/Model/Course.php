<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Model;

use JsonSerializable;

class Course implements JsonSerializable {
    
    private string $name;
    private string $startTime;
    private string $endTime;
    private string $link;
    private array $days;
    
    public function __construct(
        string $name,
        string $startTime,
        string $endTime,
        string $link,
        array $days
    ) {
        $this->name = $name;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->link = $link;
        $this->days = $days;
    }
    
    public function __toString(): string {
        return $this->getName();
    }
    
    public function jsonSerialize(): array {
        return [
            "name" => $this->getName(),
            "startTime" => $this->getStartTime(),
            "endTime" => $this->getEndTime(),
            "link" => $this->getLink(),
            "days" => $this->getDays()
        ];
    }
    
    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getStartTime(): string {
        return $this->startTime;
    }
    
    /**
     * @return string
     */
    public function getEndTime(): string {
        return $this->endTime;
    }
    
    /**
     * @return string
     */
    public function getLink(): string {
        return $this->link;
    }
    
    /**
     * @return array
     */
    public function getDays(): array {
        return $this->days;
    }
    
    public static function fromJson(array $courseJson): Course {
        return new Course(
            $courseJson["name"],
            $courseJson["startTime"],
            $courseJson["endTime"],
            $courseJson["link"],
            $courseJson["days"],
        );
    }
    
}
