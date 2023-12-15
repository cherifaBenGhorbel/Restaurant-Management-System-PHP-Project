<?php

class RestaurantOwner {
    protected $ownerRes, $firstName, $lastName, $gender, $email, $password;

    public function __construct($ownerRes = 0, $firstName = "", $lastName = "", $gender = "", $email = "", $password = "") {
        $this->ownerRes = $ownerRes;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->email = $email;
        $this->password = $password;
    }

    public function getOwnerRes() { return $this->ownerRes; }
    public function setOwnerRes($ownerRes) { $this->ownerRes = $ownerRes; }

    public function getFirstName() { return $this->firstName; }
    public function setFirstName($firstName) { $this->firstName = $firstName; }

    public function getLastName() { return $this->lastName; }
    public function setLastName($lastName) { $this->lastName = $lastName; }

    public function getGender() { return $this->gender; }
    public function setGender($gender) { $this->gender = $gender; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }
}

?>