<?php
session_start();
include_once('../../../controllers/reservationController.php');
include_once('../../../models/reservation.php');
if (!isset($_SESSION['idC'])) {
    header("Location: ../SignIn/SignIn.php");
    exit();
}
$reservationId = $_GET['reservationId'];
$reservationController = new ReservationController();
$reservation = $reservationController->getReservationById($reservationId);

if (!$reservation || $reservation->getIdC() != $_SESSION['idC']) {
    echo "Invalid reservation or permission denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $result = $reservationController->delete($reservationId);

    if ($result) {
        header('Location: ../listeReservation/clientReservations.php'); 
        exit();
    } else {
        echo "Failed to delete the reservation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/header.css">
<title>YourFavourite</title>

<style>


main {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.form-container {
    width: 100%;
    max-width: 600px;
    background-color: #222;
    border-radius: 12px;
    padding: 3rem;
    margin: auto;
}

.main-form {
    max-width: 400px;
    margin: auto;
}

.input {
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 1rem;
    border: 2px solid #ababab;
    border-radius: 8px;
}

.input label {
    margin-right: 1rem;
}

.input input,
.button button {
    border: 0;
    background-color: transparent;
    height: 100%;
    width: 100%;
    color: white;
    padding: 0.85rem 1rem;
    margin: 3%;
}

.input input {
    background-color: transparent;
}

.input:focus-within {
    border-color: #fbbc05;
}

.input:focus-within label {
    color: #fbbc05;
}

.button {
    
    width: 80%;
    text-align: left;
}

.button button {
    width: max-content;
    padding: 10px 30px;
    background-color: #fbbc05;
    color: white;
    border-radius: 8px;
    transition: 0.3s ease-in-out;
    font-size: 1.25rem;
}

.button button:hover,
.button button:focus {
    background-color: #e09900;
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
            <div class="form-container">
                <h2>Confirm Deletion</h2>
                <p>Are you sure you want to delete this reservation?</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?reservationId=' . $reservationId; ?>" method="post">
                    <div class="button">
                        <button type="submit" class="btn send-msg">Delete</button>
                        <a href="../listeReservation/clientReservations.php" class="btn send-msg">Cancel</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="../JS/nav.js"></script>
</body>
</html>
