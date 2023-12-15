<?php
include_once('../../../models/restaurant.php');
include_once('../../../controllers/restaurantController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $phoneNumber = $_POST['phoneNumber'];
    $capacity = $_POST['capacity'];

    if ($_SESSION['userType'] === 'restaurantOwner')  {
        $ownerRes = $_SESSION['ownerRes'];

        $targetDir = '../../../images/RestaurantsImages/';
        $targetFileResImage = $targetDir . basename($_FILES['resImage']['name']);
       

        $targetDirMenu = '../../../images/Menu/';
        $targetFileMenuImage = $targetDirMenu . basename($_FILES['menuImage']['name']);

        try {
            if (move_uploaded_file($_FILES['resImage']['tmp_name'], $targetFileResImage)) {
                echo "The file " . basename($_FILES['resImage']['name']) . " has been uploaded for the restaurant image.";

                if (move_uploaded_file($_FILES['menuImage']['tmp_name'], $targetFileMenuImage)) {
                    echo "The file " . basename($_FILES['menuImage']['name']) . " has been uploaded for the menu image.";

                    $restaurant = new Restaurant($name, $targetFileResImage, $type, $location, $targetFileMenuImage, $phoneNumber, $capacity, $ownerRes);

                    $restaurantController = new RestaurantController();
                    $result = $restaurantController->insert($restaurant);

                    if ($result) {
                        echo "Restaurant added successfully!";
                        header('Location: ../ownerDashboard/home.php');
                        exit();
                    } else {
                        throw new Exception("Failed to add restaurant.");
                    }
                } else {
                    throw new Exception("Error: There was an error uploading your menu file.");
                }
            } else {
                throw new Exception("Error: There was an error uploading your restaurant image file.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Session variable 'restaurantOwner' not set.";
    }
} else {
    echo "Invalid request method.";
}
?>
