<?php
session_start();
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
require('../../../vendor/autoload.php');
include_once('../../../controllers/clientController.php');
include_once('../../../controllers/restaurantOwnerController.php');
use RobThree\Auth\TwoFactorAuth;
$_SESSION['2fa_verified'] = false;

if (!isset($_SESSION['userType']) ) {
    header('Location: ../SignIn/SignIn.php');
    exit();
}
    $tfa = new TwoFactorAuth();
    $errorMessage = '';
    if($_SESSION['userType'] == "client"){
        $clientController = new ClientController();
        $id = $_SESSION['idC'];
        $user = $clientController->getClientById($id);
        $redirectUrl = '../clientDashboard/home.php';
        $navURL= '../clientNav/navC.php';

    }
    else{
        $restauOWControler = new RestaurantOwnerController();
        $idResto = $_SESSION['ownerRes'];
        $user = $restauOWControler->getRestaurantOwnerById($idResto);
        $redirectUrl = '../ownerDashboard/home.php';
        $navURL= '../ownerResNav/navO.php';
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['tfa_code'])) {
        $tfaCode = $_POST['tfa_code'];
        if (!$user['secret'] || $tfa->verifyCode($user['secret'], $tfaCode)) {
            $_SESSION['2fa_verified'] = true;
            header("Location: $redirectUrl");
            exit();
        } else {
            $errorMessage = "Please re-enter your 2FA code";
        }
    }

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Styles/header.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            color: black;
            /* Ensure container has a minimum height */
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-input {
            margin: 20px 0;
            padding: 10px;
            width: calc(100% - 22px);
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        .btn {
            background-color: #fbbc05;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #FFDD95;
        }
        .info-message {
            color: #fbbc05;
            margin: 20px 0;
            padding: 10px;
            height: 50px; 
            text-align: left;
            font-size: 13px;
            font-weight: bolder;
        }
    </style>
</head>
<body>
    <header style="position: fixed; top: 0; left: 0; right: 0; z-index: 999;">
        <nav class="navbar">
            <?php include("$navURL"); ?>
        </nav>
    </header>
    <main>
        <div class="container">
            <h1>2FA Verification</h1>
            <form id="2faForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                <input type="text" placeholder="Please enter your 2FA code" name="tfa_code" class="form-input" id="tfaCode">
                    <?php if (!empty($errorMessage)): ?>
                        <i class="info-message"><?= $errorMessage ?></i>
                    <?php endif; ?>
                <button type="submit" class="btn">Verify Code</button>
            </form>
        </div>
    </main>
    <script>
        window.onload = function() {
            document.getElementById('2faForm').reset();
        };
    </script>
</body>
</html>
