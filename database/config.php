<?php
abstract class Connexion {
protected $pdo;
function __construct()
{
    try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=restaurant', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}

function __destruct()
{
$this->pdo=null;
}



}
?>