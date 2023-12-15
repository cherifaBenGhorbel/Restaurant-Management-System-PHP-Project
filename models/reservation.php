<?php

class Reservation {
    protected $restaurantId, $idC, $date, $time, $adults, $babies;

    public function __construct($restaurantId, $idC, $date, $time, $adults, $babies) {
        $this->restaurantId = $restaurantId;
        $this->idC = $idC;
        $this->date = $date;
        $this->time = $time;
        $this->adults = $adults;
        $this->babies = $babies;
    }

    public function getRestaurantId() {
        return $this->restaurantId;
    }

    public function setRestaurantId($restaurantId) {
        $this->restaurantId = $restaurantId;
    }

    public function getIdC() {
        return $this->idC;
    }

    public function setIdC($idC) {
        $this->idC = $idC;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function getAdults() {
        return $this->adults;
    }

    public function setAdults($adults) {
        $this->adults = $adults;
    }

    public function getBabies() {
        return $this->babies;
    }

    public function setBabies($babies) {
        $this->babies = $babies;
    }
}

?>
