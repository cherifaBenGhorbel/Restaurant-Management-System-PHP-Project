<?php
session_start();
include_once('../../../controllers/reservationController.php');
include_once('../../../models/reservation.php');

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['userType']) || !isset($_SESSION['idC']) || $_SESSION['userType'] !== 'client') {
    header('Location: ../SignIn/SignIn.php');
    exit();
}
$reservationController = new ReservationController();

$reservationId = $_GET['reservationId'];
$reservation = $reservationController->getReservationById($reservationId);

if (!$reservation || $reservation->getIdC() != $_SESSION['idC']) {
    echo "Invalid reservation or permission denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $adults = $_POST['adults'];
    $babies = $_POST['babies'];
    if (is_object($reservation)) {
        $reservation->setDate($date);
        $reservation->setTime($time);
        $reservation->setAdults($adults);
        $reservation->setBabies($babies);
    } else {
        echo "Invalid reservation or permission denied.";
        exit();
    }

    $result = $reservationController->update($reservation, $reservationId);

    if ($result) {
        header('Location: ../listeReservation/clientReservations.php'); 
        exit();
    } else {
        echo "Failed to update the reservation.";
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
    height: 100%;
    width: 100%;
    color: white;
    padding: 0.85rem 1rem;
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
    width: 100%;
    text-align: center;
}

.button button {
    width: max-content;
    padding: 15px 30px;
    background-color: #fbbc05;
    color: white;
    border-radius: 8px;
    transition: 0.3s ease-in-out;
    font-size: 1rem;
}

.button button:hover,
.button button:focus {
    background-color: #e09900;
}


</style>
</head>
<body>
<header style="position: fixed; top: 0; left: 0; right: 0; z-index: 999;">
        <nav class="navbar">
            <?php include('../clientNav/navC.php'); ?>
        </nav>
</header>
    <main>
        <section>
            <h2>Edit Reservation</h2>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?reservationId=' . $reservationId; ?>" method="post" class="main-form">
            <div class="input">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required value="<?php echo $reservation->getDate(); ?>">
            </div>
            <div class="input">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required value="<?php echo $reservation->getTime(); ?>">
            </div>
            <div class="input">
                <label for="adults">Adults:</label>
                <input type="number" id="adults" name="adults" required value="<?php echo $reservation->getAdults(); ?>">
            </div>

            <div class="input">
                <label for="babies">Babies:</label>
                <input type="number" id="babies" name="babies" required value="<?php echo $reservation->getBabies(); ?>">
            </div>
                <div class="button">
                    <button type="submit" class="btn send-msg">Update Reservation</button>
                </div>
            </form>
        </section>
    </main>

    <script src="../JS/nav.js"></script>
</body>
</html>
