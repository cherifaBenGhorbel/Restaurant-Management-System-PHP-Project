<div class="nav-title">
    <span>YourFavourite</span>
</div>
<div class="nav-content">
    <ul>
        <?php 
            include_once('../../../controllers/restaurantOwnerController.php');
            $restauOWControler = new RestaurantOwnerController();
            $id = $_SESSION['ownerRes'];
            $has2FA = $restauOWControler->getSecret($id) ? "Disable 2FA" : "Enable 2FA";
            $_SESSION["has2FA"] = $has2FA;
            if ($_SESSION['2fa_verified'] == true ) {
        ?>
        <li>
            <a href="../ownerDashboard/home.php">HOME</a>
        </li>
        <li>
            <a href="../AddRestaurant/addR.php">Add Restaurant</a>
        </li>
        <li>
            <a href="../doubleAuthentication/2fa_settingsOR.php">
                <?php echo $_SESSION["has2FA"]; ?>
            </a>
        </li>
        <li class="btn sign-out">
            <?php echo $_SESSION['lastName'].' '.$_SESSION['firstName']?>
        </li>
        <li>
            <a class="btn sign-out" href="../LogOut/end.php">Sign Out</a>
        </li>
    </ul>
    <i id="close" class="fa-solid fa-xmark"></i>
</div>
<div class="mobile">
    <i class="bar fa-solid fa-utensils"></i>
</div>
<?php  }?>


<style>
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

     @media (max-width: 960px) {

        .nav-content ul {
            flex-direction: column;
        }

        .nav-content i {
            display: none;
        }        

        .nav-content li a{
            font-size: 14px;
        }   

        .nav-content .btn.sign-out {
            margin-top: 30%;
            width: 70%;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
       }
    }
/* when the screen size is smaller than 960, it will show the close button */
     @media only screen and (orientation: landscape) and (max-height: 480px){
        .nav-content i {
            display: block;
        }}

</style>