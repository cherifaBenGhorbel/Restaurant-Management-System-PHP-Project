<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="../../Styles/Caccount.css"> 
    <link rel="stylesheet" href="../../Styles/contact.css">
    <link rel="stylesheet" href="../../Styles/header.css">
    <link rel="stylesheet" href="../../Styles/footer.css">
    <link rel="icon" type="image/x-icon" href="/assets/android-chrome-192x192.png">
    <title>Create An Account</title>
    <style>.btn.send-msg {
    background-color: #fbbc05;
    color: white;
    margin-top: 3%;
}
.input:focus-within {
    border-color: #fbbc05;
}
.btn.send-msg:hover {
    background-color: #e09900; 
}
#aa{
    color:black;
    font-weight: bolder;
}
#aa :hover{
    color:#e09900;
    font-weight: bolder;
}</style>

</head>
<body>
    <header style="position: fixed; top: 0; left: 0; right: 0; z-index: 999;">
        <nav class="navbar">
            <div class="nav-title">
                <span>YourFavourite</span>
            </div>
        </nav>
    </header>
    <main>
        <section>
            <div class="form-container">
                <form action="register.php" method="post" class="main-form">
                    <input type="hidden" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                    <input type="hidden" name="lname" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                    <input type="hidden" name="gender" value="<?php echo isset($_POST['gender']) ? $_POST['gender'] : ''; ?>">

                <div class="email">
                        <h2>Email</h2>
                        <div class="input">
                            <label for="email"><i class="far fa-envelope"></i></label>
                            <input type="text" id="email" name="email" autocomplete required>
                        </div>
                    </div>
                    <div class="password">
                        <h2>Password</h2>
                        <div class="input">
                            <label for="password"><i class="fa-solid fa-unlock-keyhole"></i></label>
                            <input type="password" id="password" name="password" autocomplete required>
                        </div>
                    </div>
                    <div class="user-type">
                        <h2>User Type</h2>
                        <div class="radio-group">
                            
                            <label for="client">Client</label>
                            <input type="radio" id="client" name="userType" value="client" checked>
                            
                            <label for="restaurantOwner">Restaurant Owner</label>
                            <input type="radio" id="restaurantOwner" name="userType" value="restaurantOwner">
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" class="btn send-msg" value="Sign In"></button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="../js/nav.js">
    </script>
</body>
</html>
