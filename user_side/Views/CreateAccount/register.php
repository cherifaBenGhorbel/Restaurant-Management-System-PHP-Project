<?php
session_start();
include_once('../../../models/client.php');
include_once('../../../models/owner.php');
include_once('../../../controllers/restaurantOwnerController.php');
include_once('../../../controllers/clientController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    if ($userType == 'restaurantOwner') {
        $newUser = new RestaurantOwner(null, $firstName, $lastName, $gender, $email, $password);
        $roController = new RestaurantOwnerController();
        $_SESSION['estClient'] = false;
        
    } else {
        $newUser = new Client($firstName, $lastName, $gender, $email, $password);
        $roController = new ClientController();
        $_SESSION['estClient'] = true;
    }

    if ($roController->insert($newUser)) {
        echo "Subscription successful!";
        header ('location: ../SignIn/SignIn.php');
    } else {
        echo "Subscription failed!";
    }
}
?>
