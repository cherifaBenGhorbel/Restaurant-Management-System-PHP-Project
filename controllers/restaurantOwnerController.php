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

    function getRestaurantOwnerById($id) {
        $query = "SELECT * FROM restaurantowner WHERE ownerRes = ?";
        $res = $this->pdo->prepare($query);
        $res->execute(array($id));
        return $res->fetch(PDO::FETCH_ASSOC);
    }
    function addSecret($id,$secret){
        $query = 'UPDATE restaurantowner SET secret = :secret WHERE ownerRes = :id';
        $q = $this->pdo->prepare($query);
        $q->bindValue('secret', $secret);
        $q->bindValue('id', $id);
        $q->execute();
    }

    function getSecret($id){
        $query = "SELECT secret FROM restaurantowner WHERE ownerRes = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT); 
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['secret'] : null; // Return the secret or null if not found
    }
    public function is2FAEnabled($id) {
        $secret = $this->getSecret($id);
        return !empty($secret);
    }
    function removeSecret($id){
        $query = 'UPDATE restaurantowner SET secret = NULL WHERE ownerRes = :id';
        $req = $this->pdo->prepare($query);
        $req->bindValue("id",$id,PDO::PARAM_INT);
        $req->execute();
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
