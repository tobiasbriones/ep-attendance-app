<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Model;

use JsonSerializable;

// Just that for this application :D
class Instructor implements JsonSerializable {
    
    private string $email;
    private string $name;
    
    public function __construct($email, $name = "-") {
        $this->email = $email;
        $this->name = $name;
    }
    
    public function __toString(): string {
        return $this->getEmail();
    }
    
    public function jsonSerialize(): array {
        return [
            "email" => $this->getEmail(),
            "name" => $this->getName()
        ];
    }
    
    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }
    
    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
    
    public static function fromJson(string $email, array $instructorJson): Instructor {
        return new Instructor(
            $email,
            $instructorJson["name"]
        );
    }
    
}
