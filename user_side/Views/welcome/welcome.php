<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="../../Styles/header.css">
    <link rel="stylesheet" href="../../Styles/main.css">
    <link rel="stylesheet" href="../../Styles/footer.css">
    <link rel="stylesheet" href="../../Styles/foodcategory.css">
    <?php
        include_once('../../../controllers/restaurantController.php');
        include_once('../../../models/restaurant.php');
        $restaurantController = new RestaurantController();
        $restaurants = $restaurantController->getAllRestaurantsOfAllOwners();
        
    ?>



    <title>YourFavourite</title>
</head>
<body>
    <header style="position: fixed; top: 0; left: 0; right: 0; z-index: 999;">
        <nav class="navbar">
            <div class="nav-title">
                <span>YourFavourite</span>
            </div>
            <div class="nav-content">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><i id="close" class="fa-solid fa-xmark"></i></li>
                </ul>
                <button class="btn order"><a href="../CreateAccount/CreateAccountP1.php">Create an Account</a></button>
                <button class="btn order" id="ss"><a href="../SignIn/SignIn.php">Sign in</a></button>
            </div>
            <div class="mobile">
                <i class="bar fa-solid fa-utensils"></i>
            </div>
        </nav>
    </header>
    <main>
        <section class="hero">
            <div class="landing-hero">
                <h1>When You Find <span class="food" style="color: var(--clr-main-theme);">YourFavourite</span> <br>You Find Happiness</h1>
                <p>Introducing <span class="title-part" style="font-weight: 800;">YourFavourite</span>, We’re always in the mood for food.</p>
                <button class="btn get-started"><a href="../clientDashboard/home.php">Get Started</a></button>
            </div>
            <div class="landing-img">
                <img class="one" src="../../../images/TypeImages/I1.jpg"alt="">
                <img class="two" src="../../../images/TypeImages/I2.jpg" alt="">
                <img class="three" src="../../../images/TypeImages/I3.jpg" alt="">
            </div>
        </section>
        <section class="below-hero">
            <div class="about-heading">
                <div class="heading-img"><img src="../../../images/TypeImages/about.jpg" width="400" alt=""></div>
                <div class="heading-content">
                    <p class="sub-title">ABOUT US</p>
                    <h2>What's Special About Our Services ?</h2>
                    <p class="heading-description">We prioritize our customers and their trust as the cornerstone of our platform. Ensuring top-notch quality is non-negotiable for us, and our dedicated team consistently monitors and maintains high standards.</p>
                </div>
            </div>
        </section>
        <section class="hero-menu-cards">
        <p class="sub-title">POPULAR RESTAURANTS</p>
        <h2>What's Trending</h2>
        <div class="container">
        <?php foreach ($restaurants as $restaurant): ?>
    <div class="restaurant">
        <?php
        $imagePath = $restaurant['resImage'];
        if (file_exists($imagePath)) {
            echo '<img src="' . $imagePath . '" alt="Restaurant Image">';
        } else {
            echo '<p>Image not found at ' . $imagePath . '</p>';
        }
        ?>
        <h4><?php echo $restaurant['name']; ?></h4>
        <p class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></p>
    </div>
<?php endforeach; ?>


        </div>
    </section>
        <section class="categories">
            <p class="sub-title">RESTAURANTS CATEGORIES</p>
            <h2>What Types of Restaurants We have ?</h2>
            <div class="cat-container">
                <div class="col-l-4">
                    <div class="cat-description fixedindian">
                        <h5>CASUAL</h5>
                        <p>Casual restaurants are places where you can enjoy delicious and affordable food in a relaxed and friendly atmosphere.</p>
                        <button class="btn order-now"><a href="../AddReservation/reservationForm.php">Reserve Now</a></button>
                    </div>
                    <div class="cat-img moveupindian"><img src="../../../images/TypeImages/Casual.jpg" width="400" alt=""></div>
                </div>
                <div class="col-l-4">
                    <div class="cat-img"><img src="../../../images/TypeImages/FastFood.jpg" width="400" alt=""></div>
                    <div class="cat-description">
                        <h5>FAST-FOOD</h5>
                        <p>Fast-Food restaurants are the ultimate destinations for busy and adventurous eaters who want to enjoy a variety of delicious and affordable dishes.</p>
                        <button class="btn order-now"><a href="../AddReservation/reservationForm.php">Reserve Now</a></button>
                    </div>
                </div>
                <div class="col-l-4">
                    <div class="cat-description fixeditalian">
                        <h5>FINE DINING</h5>
                        <p>Fine Dining restaurants are the best places to enjoy a sophisticated and elegant meal, with high-quality food and service, and a refined and classy ambiance.</p>
                        <button class="btn order-now"><a href="../AddReservation/reservationForm.php">Reserve Now</a></button>
                    </div>
                    <div class="cat-img moveupitalian"><img src="../../../images/TypeImages/Fine-dining.jpg" width="400" alt=""></div>
                </div>
            </div>
        </section>

    </main>
    <footer>
        

        <div class="copyright">
            <p>© Copyright 2023 - YourFavourite</p>
        </div>
    </footer>
    
</body>
<script src="../../JS/nav.js"></script>
</html>