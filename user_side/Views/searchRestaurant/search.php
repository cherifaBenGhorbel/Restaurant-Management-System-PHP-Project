<?php
include_once('../../../controllers/restaurantController.php');
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['userType']) || !isset($_SESSION['idC']) || $_SESSION['userType'] !== 'client') {
    header('Location: ../SignIn/SignIn.php');
    exit();
}

$restaurantController = new RestaurantController();

$distinctTypes = $restaurantController->getDistinctTypes();
$distinctLocations = $restaurantController->getDistinctLocations();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $selectedType = $_GET['type'] ?? null;
    $selectedLocation = $_GET['location'] ?? null;

    if (empty($selectedType) && empty($selectedLocation)) {
        $restaurants = $restaurantController->getAllRestaurantsOfAllOwners();
    } else {
        if (!empty($selectedType) && empty($selectedLocation)) {
            $restaurants = $restaurantController->getRestaurantsByType($selectedType);
        } elseif (empty($selectedType) && !empty($selectedLocation)) {
            $restaurants = $restaurantController->getRestaurantsByLocation($selectedLocation);
        } else {
            $restaurants = $restaurantController->getRestaurantsByTypeAndLocation($selectedType, $selectedLocation);
        }
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
            color: #fbbc05;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .restaurant a:hover {
            color: white;
        }

        form {
            background-color: transparent;
            margin: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 100%;
            max-width: 100%;
            border: 2px solid #fbbc05;
            color: #fbbc05;
            padding: 8px 16px;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: black;
            color: white;
        }

        button {
            background-color: #fbbc05;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
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
    <main class="hero">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <label for="type">Select Type:</label>
            <select id="type" name="type">
                <option value="">All Types</option>
                <?php foreach ($distinctTypes as $type): ?>
                    <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="location">Select Location:</label>
            <select id="location" name="location">
                <option value="">All Locations</option>
                <?php foreach ($distinctLocations as $location): ?>
                    <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Search</button>
        </form>
        <h2>Search results</h2>
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
                            <a href="../restaurantDetailles/restaurant_details.php?restaurantId=<?php echo $restaurant['restaurantId']; ?>">View Details</a>
                        </div>
                    <?php endforeach; ?>
                </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
            <p>No matching restaurants found.</p>
        <?php endif; ?>
        </section>

    </main>
</body>

</html>
