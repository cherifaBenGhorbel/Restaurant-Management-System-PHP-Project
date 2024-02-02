<?php
session_start();
include_once('../../../controllers/clientController.php');
include_once('../../../controllers/restaurantOwnerController.php');
require('../../../vendor/autoload.php');
use RobThree\Auth\TwoFactorAuth;
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
        $_SESSION["has2FA"] = "Enable 2FA" ;
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
    $tfaCode = $_POST['tfa_code'];

    if (!empty($email) && !empty($password)) {

    $roController = new RestaurantOwnerController();
    $clientController = new ClientController();

    echo "Form submitted";  

    if (authenticateUser($roController, $email, $password, 'restaurantOwner')) {
        $userDetails = $roController->getRestaurantOwner($email);
        $_SESSION['ownerRes'] = $userDetails['ownerRes'];
        // Checking for 2fa
        if ($roController->is2FAEnabled($_SESSION['ownerRes'])) {
            header('Location: ../doubleAuthentication/enter_2fa_code.php');
            $_SESSION['2fa_verified'] = false;
            exit();
        }
        else{
            echo "Login successful as Restaurant Owner!"; 
            header('Location: ../ownerDashboard/home.php');  
            $_SESSION['2fa_verified'] = true;
            exit();
        }
    } elseif (authenticateUser($clientController, $email, $password, 'client')) {
        $userDetails = $clientController->getClient($email);
        $_SESSION['idC'] = $userDetails['idC'];
        // Checking for 2fa
        if ($clientController->is2FAEnabled($_SESSION['idC'])) {
            header('Location: ../doubleAuthentication/enter_2fa_code.php');
            $_SESSION['2fa_verified'] = false;
            exit();
        }
        else{
            header('Location: ../clientDashboard/home.php');
            $_SESSION['2fa_verified'] = true;
            exit();
        }
    } else {
        echo "Login failed: Incorrect email or password!";
        header('Location: ../SignIn/SignIn.php'); 
    }
}}
?>
