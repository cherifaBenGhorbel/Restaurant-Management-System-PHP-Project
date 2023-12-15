<?php
session_start();
include_once('../../../controllers/clientController.php');
include_once('../../../controllers/restaurantOwnerController.php');
function authenticateUser($controller, $email, $password, $userType) {
    $email = htmlspecialchars($email);

    if ($userType === 'restaurantOwner') {
        $userDetails = $controller->getRestaurantOwner($email);
    } elseif ($userType === 'client') {
        $userDetails = $controller->getClient($email);
    }

    if ($userDetails && password_verify($password, $userDetails['password'])) {
        $Details = array_map('htmlspecialchars', $userDetails);
        $_SESSION['loggedin'] = true;
        $_SESSION['userType'] = $userType;
        $_SESSION['firstName'] = $Details['firstName'];
        $_SESSION['lastName'] = $Details['lastName'];
        $_SESSION['gender'] = $Details['gender'];
        $_SESSION['email'] = $Details['email'];
        return true;
    }

    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $roController = new RestaurantOwnerController();
    $clientController = new ClientController();

    echo "Form submitted";  

    if (authenticateUser($roController, $email, $password, 'restaurantOwner')) {
        $userDetails = $roController->getRestaurantOwner($email);
        $_SESSION['ownerRes'] = $userDetails['ownerRes'];
        echo "Login successful as Restaurant Owner!"; 
        header('Location: ../ownerDashboard/home.php');  
        exit;
    } elseif (authenticateUser($clientController, $email, $password, 'client')) {
        $userDetails = $clientController->getClient($email);
        $_SESSION['idC'] = $userDetails['idC'];
        echo "Login successful as Client!"; 
        header('Location: ../clientDashboard/home.php'); 
        exit;
    } else {
        echo "Login failed: Incorrect email or password!";
        header('Location: ../SignIn/SignIn.php'); 
    }
}
?>
