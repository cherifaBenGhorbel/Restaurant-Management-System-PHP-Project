<?php

class Client {
    protected $firstName, $lastName, $gender, $email, $password;

    public function __construct($firstName = "", $lastName = "", $gender = "", $email = "", $password = "") {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->email = $email;
        $this->password = $password;
    }

    public function getFirstName() { return $this->firstName; }
    public function setFirstName($f) { $this->firstName = $f; }

    public function getLastName() { return $this->lastName; }
    public function setLastName($l) { $this->lastName = $l; }

    public function getGender() { return $this->gender; }
    public function setGender($g) { $this->gender = $g; }

    public function getEmail() { return $this->email; }
    public function setEmail($e) { $this->email = $e; }

    public function getPassword() { return $this->password; }

    public function setPassword($password) { $this->password = $password;}
}