<?php
include_once(__DIR__.'/../models/client.php') ;
include_once(__DIR__.'/../database/config.php');
class ClientController extends Connexion {
    function __construct() {
        parent::__construct();
    }

    function insert(Client $c) {
        $query = "INSERT INTO client(firstName, lastName, gender, email,password) VALUES (?, ?, ?, ?, ?)";
        $res = $this->pdo->prepare($query);

        // Hash the password before storing
        $hashedPassword = password_hash($c->getPassword(), PASSWORD_DEFAULT);

        $aryy = array($c->getFirstName(), $c->getLastName(), $c->getGender(), $c->getEmail(), $hashedPassword);
        return $res->execute($aryy);
    }

    function addSecret($idC,$secret){
        $query = 'UPDATE client SET secret = :secret WHERE idC = :idC';
        $q = $this->pdo->prepare($query);
        $q->bindValue('secret', $secret);
        $q->bindValue('idC', $idC);
        $q->execute();
    }
    function getSecret($id){
        $query = "SELECT secret FROM client WHERE idC = ?";
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
        $query = 'UPDATE client SET secret = NULL WHERE idC = :id';
        $req = $this->pdo->prepare($query);
        $req->bindValue("id",$id,PDO::PARAM_INT);
        $req->execute();
    }
    function getClient($email) {
        $query = "SELECT * FROM client WHERE email = ?";
        $res = $this->pdo->prepare($query);
        $res->execute(array($email));
        return $res->fetch();
    }
    function getClientById($idC) {
        $query = "SELECT * FROM client WHERE idC = ?";
        $res = $this->pdo->prepare($query);
        $res->execute(array($idC));
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    function delete($idClient) {
        $query = "DELETE FROM client WHERE idClient=?";
        $res = $this->pdo->prepare($query);
        return $res->execute(array($idClient));
    }

    function liste() {
        $query = "SELECT * FROM client";
        $res = $this->pdo->prepare($query);
        $res->execute();
        return $res;
    }

    function modifier_user(Client $c) {
        $sql = "UPDATE client SET lastName=?, firstName=?, gender=? WHERE email=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($c->getLastName(), $c->getFirstName(), $c->getGender(), $c->getEmail()));
    }
}
?>
