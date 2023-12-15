<?php
session_start();
include_once('../../../models/restaurant.php');
include_once('../../../controllers/restaurantController.php');

if (!isset($_SESSION['ownerRes'])) {
    header("Location: ../SignIn/SignIn.php");
    exit();
}

$restaurantId = filter_input(INPUT_GET, 'restaurantId', FILTER_VALIDATE_INT);

if ($restaurantId === null || $restaurantId === false) {
    echo "Invalid restaurant ID.";
    exit();
}

$ownerRes = $_SESSION['ownerRes'] ?? null;

$restaurantController = new RestaurantController();

$restaurant = $restaurantController->getRestaurantById($restaurantId);

if (!$restaurant) {
    echo "Restaurant not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $type = htmlspecialchars($_POST['type']);
    $location = htmlspecialchars($_POST['location']);
    $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
    $capacity = htmlspecialchars($_POST['capacity']);

    $targetFileResImage = '';
    $targetFileMenuImage = '';

    if (!empty($_FILES['resImage']['name'])) {
        $targetDir = '../../../images/RestaurantsImages/';
        $targetFileResImage = $targetDir . basename($_FILES['resImage']['name']);

        if (!move_uploaded_file($_FILES['resImage']['tmp_name'], $targetFileResImage)) {
            echo "Error: There was an error uploading your restaurant image file.";
            exit();
        }
    }

    if (!empty($_FILES['menuImage']['name'])) {
        $targetDirMenu = '../../../images/Menu/';
        $targetFileMenuImage = $targetDirMenu . basename($_FILES['menuImage']['name']);

        if (!move_uploaded_file($_FILES['menuImage']['tmp_name'], $targetFileMenuImage)) {
            echo "Error: There was an error uploading your menu file.";
            exit();
        }
    }

    $restaurant = new Restaurant($name, $targetFileResImage, $type, $location, $targetFileMenuImage, $phoneNumber, $capacity, $ownerRes);

    try {
        $result = $restaurantController->update($restaurant, $restaurantId);
        if ($result) {
            echo "Restaurant updated successfully!";
            header("Location: ../ownerDashboard/home.php");
            exit();
        } else {
            echo "Failed to update restaurant.";
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"> 
    <link rel="stylesheet" href="../../Styles/header.css">
    <title>YourFavourite</title>
    <style>
        a {
            text-decoration: none;
            color: var(--clr-main-light);
        }

        .main {
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
    margin-top: 80px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
    color: white;
    max-width: 400px;
    margin: auto;
}

label {
    margin-top: 10px;
    font-weight: bold;
}

        input,
        select {
            margin-top: 5px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="file"] {
            padding: 5px;

        }.input input {
    background-color: transparent;
}

.input:focus-within {
    border-color: #fbbc05;
}

.input:focus-within label {
    color: #fbbc05;
}

        input[type="submit"] {
            background-color: #fbbc05;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
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
        <section>
            <div class="form-container">
                <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?restaurantId=' . $restaurant['restaurantId']; ?>">
                    <input type="hidden" name="restaurantId" value="<?php echo $restaurant['restaurantId']; ?>">

                    <label for="name">Restaurant Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $restaurant['name']; ?>" required>

                    <label for="resImage">Restaurant Image:</label>
                    <input type="file" name="resImage" accept="image/*"><br>

                    <label>Restaurant Type:</label>
                    <input type="radio" name="type" value="casual" <?php echo ($restaurant['type'] == 'casual') ? 'checked' : ''; ?>> Casual
                    <input type="radio" name="type" value="fine_dining" <?php echo ($restaurant['type'] == 'fine_dining') ? 'checked' : ''; ?>> Fine Dining
                    <input type="radio" name="type" value="fast_food" <?php echo ($restaurant['type'] == 'fast_food') ? 'checked' : ''; ?>> Fast Food<br>

                    <label for="location">Restaurant Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo $restaurant['location']; ?>" required>

                    <label for="menuImage">Menu Image:</label>
                    <input type="file" name="menuImage" accept="image/*"><br>

                    <label for="phoneNumber">Phone Number:</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $restaurant['phoneNumber']; ?>" required>

                    <label for="capacity">Capacity:</label>
                    <input type="number" id="capacity" name="capacity" value="<?php echo $restaurant['capacity']; ?>" required>

                    <input type="submit" value="Update Restaurant">
                </form>
            </div>
        </section>
    </main>
    <script src="../../JS/nav.js"></script>
</body>
</html>
