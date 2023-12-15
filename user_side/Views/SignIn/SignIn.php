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
    <link rel="icon" type="image/x-icon" href="/assets/android-chrome-192x192.png">
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
}
</style>

    <title>Login</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-title">
                <span>YourFavourite</span>
            </div>
        </nav>
    </header>
    <main>
        <section>
            <div class="form-container">
                <form action="Sform.php" method="post" class="main-form">
                    <div class="email">
                        <h2>Mail</h2>
                        <div class="input">
                            <label for="e-mail"><i class="far fa-envelope"></i></label>
                            <input type="text" id="e-mail" name="email" autocomplete>
                        </div>
                    </div>
                    <div class="password">
                        <h2>Password</h2>
                        <div class="input">
                            <label for="password"><i class="fa-solid fa-unlock-keyhole"></i></label>
                            <input type="password" id="password" name="password" autocomplete>
                        </div>
                    </div>
                    <div class="button">
                        <p id="acc"><a id="aa" href="../CreateAccount/CreateAccountP1.php">Don't have an account?</a> </p>
                        <input type="submit" class="btn send-msg" value="Login">
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
<script src="../js/nav.js"></script>
</html>