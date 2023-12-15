<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once(__DIR__.'/../models/owner.php');
include_once(__DIR__.'/../models/restaurant.php');
include_once(__DIR__.'/../database/config.php');

class RestaurantController extends Connexion {

    function __construct() {
        parent::__construct();
    }

    function insert(Restaurant $restaurant) {
        $query = "INSERT INTO restaurant(name, resImage, type, location, menu, phoneNumber, capacity, ownerRes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $res = $this->pdo->prepare($query);

        $aryy = array(
            $restaurant->getName(),
            $restaurant->getResImage(),
            $restaurant->getType(),
            $restaurant->getLocation(),
            $restaurant->getMenu(),
            $restaurant->getPhoneNumber(),
            $restaurant->getCapacity(),
            $restaurant->getOwnerRes()
        );

        return $res->execute($aryy);
    }

    function getRestaurantById($restaurantId) {
        $query = "SELECT * FROM restaurant WHERE restaurantId = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$restaurantId]);
    
        // Check for errors
        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] !== '00000') {
            // Log or handle the error appropriately
            error_log("Database error: " . implode(" ", $errorInfo));
            return false;
        }
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    function update(Restaurant $restaurant, $restaurantId) {
        try {
            $this->pdo->beginTransaction();
    
            // Verify ownership of restaurant owner
            if (!$this->isOwner($restaurant->getOwnerRes())) {
                // Handle unauthorized access
                throw new Exception("Unauthorized access to update restaurant.");
            }
    
            $query = "UPDATE restaurant 
                      SET name = ?, resImage = ?, type = ?, location = ?, menu = ?, phoneNumber = ?, capacity = ? 
                      WHERE restaurantId = ?";
            $stmt = $this->pdo->prepare($query);
    
            $name = $restaurant->getName();
            $resImage = $restaurant->getResImage();
            $type = $restaurant->getType();
            $location = $restaurant->getLocation();
            $menu = $restaurant->getMenu();
            $phoneNumber = $restaurant->getPhoneNumber();
            $capacity = $restaurant->getCapacity();
    
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $resImage);
            $stmt->bindParam(3, $type);
            $stmt->bindParam(4, $location);
            $stmt->bindParam(5, $menu);
            $stmt->bindParam(6, $phoneNumber);
            $stmt->bindParam(7, $capacity);
            $stmt->bindParam(8, $restaurantId);
    
            if (!$stmt->execute()) {
                throw new Exception("Update failed.");
            }
            $this->pdo->commit();
    
            return true; 
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Update transaction failed: " . $e->getMessage());
        }
    }
    
    
    
    
    function delete($restaurantId) {
        // Check if the authenticated user is restaurant owner
        $restaurant = $this->getRestaurantById($restaurantId);
        if ($this->isOwner($restaurant['ownerRes'])) {
            $query = "DELETE FROM restaurant WHERE restaurantId = ?";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute(array($restaurantId));
        } else {
            return false;
        }
    }

    function getAllRestaurants($ownerRes) {
        // Fetch only the restaurants owned by the specified restaurant owner
        $query = "SELECT * FROM restaurant WHERE ownerRes = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$ownerRes]); 
        return $stmt->fetchAll();
    }
    
    function getAllRestaurantsOfAllOwners() {
        $query = "SELECT * FROM restaurant ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    function getAllLocations() {
        $query = "SELECT DISTINCT `location` FROM `restaurant` WHERE ownerRes = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($_SESSION['ownerRes']));
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

function getDistinctTypes() {
    $query = "SELECT DISTINCT type FROM restaurant";
    $stmt = $this->pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getDistinctLocations() {
    $query = "SELECT DISTINCT location FROM restaurant";
    $stmt = $this->pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
function getRestaurantsByTypeAndLocation($type, $location) {
    $query = "SELECT * FROM restaurant WHERE
              (:type IS NULL OR type = :type) AND
              (:location IS NULL OR location = :location)";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getRestaurantsByType($type){
    $query = "SELECT * FROM restaurant WHERE
              (:type IS NULL OR type = :type)";
              $stmt = $this->pdo->prepare($query);
              $stmt->bindParam(':type', $type, PDO::PARAM_STR);
              $stmt->execute();
              return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getRestaurantsByLocation($location){
    $query = "SELECT * FROM restaurant WHERE
              (:location IS NULL OR location = :location)";
              $stmt = $this->pdo->prepare($query);
              $stmt->bindParam(':location', $location, PDO::PARAM_STR);
              $stmt->execute();
              return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    private function isOwner($ownerRes) {
        return $ownerRes === $_SESSION['ownerRes'];
    }
}
?>
