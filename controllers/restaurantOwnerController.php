<?php

include_once(__DIR__.'/../models/owner.php');
include_once(__DIR__.'/../database/config.php');

class RestaurantOwnerController extends Connexion {
    function __construct() {
        parent::__construct();
    }

    function insert(RestaurantOwner $ro) {
        $query = "INSERT INTO restaurantowner(firstName, lastName, gender, email, password) VALUES (?, ?, ?, ?, ?)";
        $res = $this->pdo->prepare($query);

        // Hash the password before storing
        $hashedPassword = password_hash($ro->getPassword(), PASSWORD_DEFAULT);

        $aryy = array($ro->getFirstName(), $ro->getLastName(), $ro->getGender(), $ro->getEmail(), $hashedPassword);
        return $res->execute($aryy);
    }

    function getRestaurantOwner($email) {
        $query = "SELECT * FROM restaurantowner WHERE email = ?";
        $res = $this->pdo->prepare($query);
        $res->execute(array($email));
        return $res->fetch();
    }

    function delete($ownerRes) {
        $query = "DELETE FROM restaurantowner WHERE ownerRes=?";
        $res = $this->pdo->prepare($query);
        return $res->execute(array($ownerRes));
    }

    function listOwners() {
        $query = "SELECT * FROM restaurantowner";
        $res = $this->pdo->prepare($query);
        $res->execute();
        return $res;
    }

    function modifyOwner(RestaurantOwner $ro) {
        $query = "UPDATE restaurantowner SET lastName=?, firstName=?, gender=? WHERE email=?";
        $res = $this->pdo->prepare($query);
        return $res->execute(array($ro->getLastName(), $ro->getFirstName(), $ro->getGender(), $ro->getEmail()));
    }
}
?>
