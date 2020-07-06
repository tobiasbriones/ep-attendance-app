<?php
/*
 * Copyright (c) 2020 Tobias Briones.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Model;

// Just that for this application :D
use JsonSerializable;

class Instructor implements JsonSerializable {
    
    private string $email;
    
    public function __construct($email) {
        $this->email = $email;
    }
    
    public function __toString(): string {
        return $this->getEmail();
    }
    
    public function jsonSerialize(): array {
        return [
            "email" => $this->getEmail()
        ];
    }
    
    public function getEmail(): string {
        return $this->email;
    }
    
}
