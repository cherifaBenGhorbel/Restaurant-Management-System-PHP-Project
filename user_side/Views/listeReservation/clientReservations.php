
<?php
session_start();
include_once('../../../controllers/reservationController.php');
include_once('../../../models/reservation.php');

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['userType']) || !isset($_SESSION['idC']) || $_SESSION['userType'] !== 'client') {
    header('Location: ../SignIn/SignIn.php');
    exit();
}



$restaurantId = $_GET['restaurantId'];

$reservationController = new ReservationController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $adults = $_POST['adults'];
    $babies = $_POST['babies'];

    $reservation = new Reservation($restaurantId, $_SESSION['idC'], $date, $time, $adults, $babies);

    $result = $reservationController->insert($reservation);

    if ($result) {
        header('Location: ../clientDashboard/home.php'); 
        exit();
    } else {
        echo "Failed to make a reservation.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourFavourite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Styles/header.css">
    <style>

.reservation-list {
    list-style: none;
    padding: 5%;
    margin: 0;
}

.reservation-list li {
    background-color: transparent;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    padding: 10px;
    overflow: hidden;
    border: 2px solid #fbbc05;
    color: #fbbc05;
    padding: 8px 16px;
    border-radius: 8px;
}

.reservation-list a {
    text-decoration: none;
    color: #fbbc05;
    margin-left: 10px;
    display: inline-block;
    white-space: nowrap;
}

.reservation-list a:hover {
    color: #e09900;
}

.nav-content .btn.sign-out {
    background-color: transparent;
    border: 2px solid #fbbc05;
    color: #fbbc05;
    padding: 8px 16px;
    border-radius: 8px;
}

.nav-content .btn.sign-out:hover {
    background-color: #fbbc05;
    color: white;
        }
    </style>
</head>
<body>
<header style="position: fixed; top: 0; left: 0; right: 0; z-index: 999;">
        <nav class="navbar">
            <div class="nav-title">
                <span>YourFavourite</span>
            </div>
            <div class="nav-content">
                <ul>
                    <li><a href="../clientDashboard/home.php">Home</a></li>
                    <li><a href="../searchRestaurant/search.php">Search</a></li>
                    <li><a href="../listeReservation/clientReservations.php">My Reservations</a></li>
                    <li class="btn sign-out"><?php echo $_SESSION['lastName'].' '.$_SESSION['firstName']?></li>
                    <li><a class="btn sign-out" href="../LogOut/end.php">Sign Out</a></li>
                </ul>
                <i id="close" class="fa-solid fa-xmark"></i>
            </div>
            <div class="mobile">
                <i class="bar fa-solid fa-utensils"></i>
            </div>
        </nav>
    </header>
    <main>
        <section>
            
            <ul class="reservation-list">
                <?php
                $clientReservations = $reservationController->getAllReservationsForClient($_SESSION['idC']);
                 if (!empty($clientReservations)){
                foreach ($clientReservations as $reservation) {
                    echo "<li>";
                    echo "Date: {$reservation['date']}, Time: {$reservation['time']}, Adults: {$reservation['adults']}, Babies: {$reservation['babies']}";
                    echo " <a href='../editReservation/editReservations.php?reservationId={$reservation['reservationId']}'>Edit</a>";
                    echo " <a href='../deleteReservation/delete.php?reservationId={$reservation['reservationId']}'>Delete</a>";
                    echo "</li>";
                }}
                else{
                    echo "<li>No reservation yet</li>";
                }
                ?>
            </ul>
        </section>
    </main>

    <script src="../JS/nav.js"></script>
</body>
</html>
