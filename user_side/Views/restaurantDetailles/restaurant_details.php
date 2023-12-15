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


.nav-content a {
    text-decoration: none;
    color: white;
    padding: 10px;
    transition: color 0.3s ease-in-out;
}

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
        }

        .restaurant-name a {
            text-decoration: none;
            color: #fbbc05;
        }

        .restaurant-name a:hover {
            text-decoration: underline;
        }

        .cat-description p {
            font-size: 1.2rem;
            color: #ababab;
            margin-bottom: 8px;
        }

        .btn.order-now a {
            font-size: 1rem;
            color: white;
            text-decoration: none;
        }

        .btn.order-now a:hover {
            text-decoration: underline;
        }
.btn {
    background-color: #fbbc05;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.btn:hover {
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

.mobile {
    display: none;
    cursor: pointer;
    font-size: 1.5rem;
}

.mobile i {
    color: white;
}

@media (max-width: 768px) {
    .nav-content ul {
        display: flex;
        flex-direction: row; 
        position: absolute;
        top: 50px;
        left: 0;
        background-color: #1d1d1d;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        text-align: center;
    }

    .mobile {
        display: block;
    }

    .mobile.opened ul {
        display: flex;
        flex-direction: column; 
    }
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
