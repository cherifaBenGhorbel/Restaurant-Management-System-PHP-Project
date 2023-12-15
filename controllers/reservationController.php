<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__.'/../database/config.php');

class ReservationController extends Connexion {

    function __construct() {
        parent::__construct();
    }

    function insert(Reservation $reservation) {
        $query = "INSERT INTO reservation(restaurantId, idC, date, time, adults, babies) VALUES (?, ?, ?, ?, ?, ?)";
        $res = $this->pdo->prepare($query);

        $array = array(
            $reservation->getRestaurantId(),
            $reservation->getIdC(),
            $reservation->getDate(),
            $reservation->getTime(),
            $reservation->getAdults(),
            $reservation->getBabies()
        );

        return $res->execute($array);
    }

    function getReservationById($reservationId) {
        $query = "SELECT * FROM reservation WHERE reservationId = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$reservationId]);

        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] !== '00000') {
            error_log("Database error: " . implode(" ", $errorInfo));
            return null;
        }
    
        $reservationData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$reservationData) {
            return null;
        }
    
        $reservation = new Reservation(
            $reservationData['restaurantId'],
            $reservationData['idC'],
            $reservationData['date'],
            $reservationData['time'],
            $reservationData['adults'],
            $reservationData['babies']
        );
    
        return $reservation;
    }
    
    
    function update(Reservation $reservation, $reservationId) {
        try {
            $this->pdo->beginTransaction();
            $query = "UPDATE reservation 
                      SET restaurantId = ?, idC = ?, date = ?, time = ?, adults = ?, babies = ? 
                      WHERE reservationId = ?";
            $stmt = $this->pdo->prepare($query);
    
            $restaurantId = $reservation->getRestaurantId();
            $idC = $reservation->getIdC();
            $date = $reservation->getDate();
            $time = $reservation->getTime();
            $adults = $reservation->getAdults();
            $babies = $reservation->getBabies();
    
            $stmt->bindParam(1, $restaurantId);
            $stmt->bindParam(2, $idC);
            $stmt->bindParam(3, $date);
            $stmt->bindParam(4, $time);
            $stmt->bindParam(5, $adults);
            $stmt->bindParam(6, $babies);
            $stmt->bindParam(7, $reservationId);
    
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
    
    function delete($reservationId) {
        $query = "DELETE FROM reservation WHERE reservationId = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(array($reservationId));
    }

    function getAllReservationsOwner($ownerRes) {
        // Fetch only the reservations for the restaurant owner
        $query = "SELECT * FROM reservation 
                  JOIN restaurant ON reservation.restaurantId = restaurant.restaurantId
                  WHERE restaurant.ownerRes = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$ownerRes]); 
        return $stmt->fetchAll();
    }
    function getAllReservationsForClient($clientId) {
        $query = "SELECT * FROM reservation WHERE idC = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }
}

?>
