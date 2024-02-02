<?php
session_start();
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
require('../../../vendor/autoload.php');
include_once('../../../controllers/restaurantOwnerController.php');

use RobThree\Auth\TwoFactorAuth;

$tfa = new TwoFactorAuth();
$restauOWControler = new RestaurantOwnerController();
$id = $_SESSION['ownerRes'];
$user = $restauOWControler->getRestaurantOwnerById($id);
$errorMessage = "";

// Check if the form is submitted for activation or deactivation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'activateTFA') {
        // User is trying to activate TFA. Check for the verification code input
        if (!empty($_POST['tfa_code'])) {
            // Verify the 2FA code
            if ($tfa->verifyCode($_SESSION['tfa_secret'], $_POST['tfa_code'])) {
                // Code is valid, save the secret in the database
                $restauOWControler->addSecret($id, $_SESSION['tfa_secret']);
                // Reload the user data to reflect the change
                $user = $restauOWControler->getRestaurantOwnerById($id);
            } else {
                $errorMessage = "Code invalide. Veuillez réessayer.";
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'deactivateTFA') {
        // User is trying to deactivate TFA
        $restauOWControler->removeSecret($id);
        // Clear the session secret and reload the user data to reflect the change
        unset($_SESSION['tfa_secret']);
        $user = $restauOWControler->getRestaurantOwnerById($id);
    }
}

if (empty($_SESSION['tfa_secret'])) {
    $_SESSION['tfa_secret'] = $tfa->createSecret();
}
$secret = $_SESSION['tfa_secret'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Setup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Styles/header.css">
    <style>
        body {
            margin-top: 100px; 
            text-align: center;
        }
        .container {
            margin: auto;
            width: 80%;
            max-width: 600px;
        }
        .btn.disactivate-now {
            background-color: #fbbc05;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn.disactivate-now:hover {
            background-color: #e0a800;
        }
        #qrCodeContainer {
            display: none;
            margin-top: 20px;
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
    <div class="container">
        <h1>Double Authentication Setup</h1>
        <br>
        <?php if (!$user['secret']): ?>
            <button id="activate2FA" class="btn disactivate-now">Activate Double Authentication</button>
            <div id="qrCodeContainer">
                <p>Scan this QR code with your Google Authenticator App :</p>
                <img src="<?= $tfa->getQRCodeImageAsDataUri('My Restaurant', $secret) ?>">
                <form action="" method="post">
                    <input type="hidden" name="action" value="activateTFA">
                    <input type="text" placeholder="Verification Code" name="tfa_code" required>
                    <button type="submit" class="btn disactivate-now">Verify</button>
                </form>
            </div>
        <?php else: ?>
            <br>
            <form action="" method="post">
                <input type="hidden" name="action" value="deactivateTFA">
                <button type="submit" class="btn disactivate-now">Deactivate Double Authentication</button>
            </form>
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?= $errorMessage ?></p>
        <?php endif; ?>
    </div>
    </main>
    <script>
        document.getElementById('activate2FA').addEventListener('click', function() {
            var qrCodeContainer = document.getElementById('qrCodeContainer');
            qrCodeContainer.style.display = qrCodeContainer.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>

