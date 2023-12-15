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
    <style>
    .btn.send-msg {
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
}
</style>
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
                <form action="CreateAccountP2.php" method="post" class="main-form">
                    <div class="name">
                        <h2>First Name</h2>
                        <div class="input">
                            <label for="name"><i class="far fa-user"></i></label>
                            <input type="text" id="fname" name="fname" autocomplete required>
                        </div>
                    </div>
                    <div class="name">
                        <h2>Last Name</h2>
                        <div class="input">
                            <label for="name"><i class="far fa-user"></i></label>
                            <input type="text" id="lname" name="lname" autocomplete required>
                        </div>
                    </div>
                    <div class="user-type">
                        <h2>Gender</h2>
                        <div class="radio-group">
                            
                            <label for="male">Male</label>
                            <input type="radio" id="gender" name="gender" value="Male" checked>
                            
                            <label for="Female">Female</label>
                            <input type="radio" id="gender" name="gender" value="Female">
                        </div>
                    </div>
                    <div class="button">
                        <p id="acc"><a id="aa" href="../SignIn/SignIn.php">Already have an account?</a> </p>
                        <input type="submit" class="btn send-msg" value="Next"></button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="../js/nav.js"></script>
</body>
</html>
