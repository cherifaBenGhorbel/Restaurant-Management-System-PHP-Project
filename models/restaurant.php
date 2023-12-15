<?php
class Restaurant {
    protected $name,$resImage, $type, $location, $menu, $phoneNumber, $capacity, $ownerRes;

    public function __construct($name,$resImage,$type, $location, $menu, $phoneNumber, $capacity, $ownerRes) {
        $this->name = $name;
        $this->resImage = $resImage;
        $this->type = $type;
        $this->location = $location;
        $this->menu = $menu;
        $this->phoneNumber = $phoneNumber;
        $this->capacity = $capacity;
        $this->ownerRes = $ownerRes;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getResImage(){
        return $this->resImage;
    }

    public function setResImage($resImage) {
        $this->resImage = $resImage;
    }

    
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function setMenu($menu) {
        $this->menu = $menu;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function getCapacity() {
        return $this->capacity;
    }

    public function setCapacity($capacity) {
        $this->capacity = $capacity;
    }

    public function getOwnerRes() {
        return $this->ownerRes;
    }

    public function setOwnerRes($ownerRes) {
        $this->ownerRes = $ownerRes;
    }
}
?>