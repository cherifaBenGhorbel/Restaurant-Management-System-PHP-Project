<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="../../Styles/header.css">
    <style>

.hero {
    text-align: center;
    margin-top: 80px;
}

.sub-title {
    font-size: 1.2rem;
    color: #fbbc05;
}

h2 {
    font-size: 2rem;
    margin-bottom: 20px;
}

.container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}


.restaurant {
    margin: 20px;
    padding: 20px;
    background-color: #1d1d1d;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column; 
    align-items: center; 
    text-align: center;
}

.restaurant img {
    max-width: 100%;
    border-radius: 8px;
}

.restaurant h4 {
    font-size: 1.5rem;
    margin-top: 10px;
    margin-bottom: 5px;
    color: #fbbc05;
}

.rating {
    color: #fbbc05;
}

.restaurant a {
    color: white;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
}

.restaurant a:hover {
    color: white;
}

.btn.order {
    margin-top: 5%;
}

.btn.order.delete {
    margin-top: 25px;
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
    <?php
        
        include_once('../../../models/restaurant.php');
        include_once('../../../controllers/restaurantController.php');
        
        if (!isset($_SESSION['loggedin']) || !isset($_SESSION['userType']) || !isset($_SESSION['ownerRes']) || $_SESSION['userType'] !== 'restaurantOwner') {
            header('Location: ../SignIn/SignIn.php');
            exit();
        }
        
        $restaurantController = new RestaurantController();
        
        $restaurants = $restaurantController->getAllRestaurants($_SESSION['ownerRes']);
    ?>

    <title>YourFavourite</title>
</head>
    <header style="position: fixed; top: 0; left: 0; right: 0; z-index: 999;">
        <nav class="navbar">
            <div class="nav-title">
                <span>YourFavourite</span>
            </div>
            <div class="nav-content">
    <ul>
    <li><a href="../ownerDashboard/home.php">HOME</a></li>
        <li><a href="../AddRestaurant/addR.php">Add Restaurant</a></li>
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
    <section class="hero">
                <?php if (!empty($restaurants)): ?>
                    <div class="container">
                    <?php foreach ($restaurants as $restaurant): ?>
                        <div class="restaurant">
                            <?php
                            $imagePath = $restaurant['resImage'];
                            if (file_exists($imagePath)) {
                                echo '<img src="' . $imagePath . '" alt="Restaurant Image" width="300 px">';
                            } else {
                                echo '<p>Image not found at ' . $imagePath . '</p>';
                            }
                            ?>
                            <h4><?php echo $restaurant['name']; ?></h4>
                            <p class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </p>
                            <button class="btn order">
                                <a href="../editRestaurant/edit.php?restaurantId=<?php echo $restaurant['restaurantId']; ?>">Edit Restaurant</a>
                            </button>

                            <button class="btn order delete">
                                <a href="../deleteRestaurant/delete.php?restaurantId=<?php echo $restaurant['restaurantId'];?>">Delete</a>
                            </button>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <button class="btn order">
                        <a href="../AddRestaurant/addR.php">add a restaurant</a>
                    </button>
                    <br>
                    <p>No restaurants found.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <script src="../JS/nav.js"></script>
</body>
</html>

   