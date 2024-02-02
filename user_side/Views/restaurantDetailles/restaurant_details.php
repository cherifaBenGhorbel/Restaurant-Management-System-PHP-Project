<?php
session_start();
include_once('../../../controllers/restaurantController.php');
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['userType']) || !isset($_SESSION['idC']) || $_SESSION['userType'] !== 'client') {
    header('Location: ../SignIn/SignIn.php');
    exit();
}
if (!isset($_GET['restaurantId'])) {
    header('Location: ../clientDashboard/home.php'); 
    exit();
}
if($_SESSION['2fa_verified'] == false){
    header('Location: ../doubleAuthentication/enter_2fa_code.php');
    exit();
}
$restaurantId = $_GET['restaurantId'];

$restaurantController = new RestaurantController();

$restaurantDetails = $restaurantController->getRestaurantById($restaurantId);
if (!$restaurantDetails) {
    header('Location: ../clientDashboard/home.php'); 
    exit();
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
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    margin-top: 80px; 
}
.restaurant-name {
            font-size: 2rem;
            color: #fbbc05;
            margin-bottom: 10px;
            text-align: center;
        }
        .cat-description p {
            font-size: 1.2rem;
            font-family: serif;
            color: #ababab;
            margin-bottom: 8px;
        }

.btn.order-now {
    background-color: #fbbc05;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.btn.order-now:hover {
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
    <section class="col-1-1">
        
        <div class="col-l-4">
                    <div class="cat-description">
                        <h1 class="restaurant-name"><?php echo $restaurantDetails['name']; ?></h1>
                        <img src="<?php echo $restaurantDetails['menu']; ?>">
                        <p>Type : <?php echo $restaurantDetails['type']; ?></p>
                        <p>Location : <?php echo $restaurantDetails['location']; ?></p>
                        <p>Phone Number : <?php echo $restaurantDetails['phoneNumber']; ?></p>
                        <button class="btn order-now">
                            <a class="reservation-link" href="../AddReservation/reservationForm.php?restaurantId=<?php echo $restaurantId; ?>">Make a Reservation</a></button>
                    </div>
                </div>
            

            

            
        </section>
    </main>

    <script src="../JS/nav.js"></script>
</body>
</html>
