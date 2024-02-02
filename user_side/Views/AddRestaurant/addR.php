<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['userType']) || !isset($_SESSION['ownerRes']) || $_SESSION['userType'] !== 'restaurantOwner') {
    header('Location: ../SignIn/SignIn.php');
    exit();
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
   
    <title>YourFavourite</title>
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
                <form action="add_Res.php" method="post" enctype="multipart/form-data">
                    <label for="name">Restaurant Name:</label>
                    <input type="text" name="name" required placeholder="Restaurant Name...">

                    <label for="resImage">Restaurant Image:</label>
                    <input type="file" name="resImage" accept="image/*" required>

                    <label>Restaurant Type:</label>
                    <input type="radio" name="type" value="casual" checked> Casual
                    <input type="radio" name="type" value="fine_dining"> Fine Dining
                    <input type="radio" name="type" value="fast_food"> Fast Food

                    <label for="location">Restaurant Location:</label>
                    <input type="text" name="location" required>

                    <label for="menuImage">Menu Image:</label>
                    <input type="file" name="menuImage" accept="image/*" required>

                    <label for="phoneNumber">Phone Number:</label>
                    <input type="text" name="phoneNumber" required>

                    <label for="capacity">Capacity:</label>
                    <input type="number" name="capacity" required>

                    <input type="submit" value="Add Restaurant">
                </form>
            </div>
        </section>
    </main>

    <script src="../../JS/nav.js"></script>
</body>
</html>
