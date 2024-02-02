<?php
session_start();
include_once('../../../models/restaurant.php');
include_once('../../../controllers/restaurantController.php');

if (!isset($_SESSION['ownerRes'])) {
    header("Location: ../SignIn/SignIn.php");
    exit();
}

$restaurantId = isset($_GET['restaurantId']) ? $_GET['restaurantId'] : null;

if (!$restaurantId) {
    echo "Invalid restaurant ID.";
    exit();
}
$restaurantController = new RestaurantController();

$restaurant = $restaurantController->getRestaurantById($restaurantId);

if (!$restaurant) {
    echo "Restaurant not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $restaurantController->delete($restaurantId);

    if ($result) {
        echo "Restaurant deleted successfully!";
        header("Location: ../ownerDashboard/home.php");
        exit();
    } else {
        echo "Failed to delete restaurant.";
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

</style>
</head>
<body>
<header style="position: fixed; top: 0; left: 0; right: 0; z-index: 999;">
        <nav class="navbar">
            <?php include('../ownerResNav/navO.php'); ?>
        </nav>
    </header>
    <main>
        <section>
            <div class="form-container">
                <h2>Confirm Deletion</h2>
                <p>Are you sure you want to delete the restaurant "<?php echo $restaurant['name']; ?>"?</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?restaurantId=' . $restaurant['restaurantId']; ?>">
                    <div class="button">
                        <button type="submit" class="btn send-msg">Delete</button>
                        <a href="../ownerDashboard/home.php" class="btn send-msg">Cancel</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="../JS/nav.js"></script>
</body>
</html>
