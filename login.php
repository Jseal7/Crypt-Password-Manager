<!DOCTYPE html>
<html lang="eng">
    <link rel="stylesheet" href="login.css">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crypt</title>
    </head>

    <body>
        <header class="headerContainer">
            <h2>Crypt Login</h2>
            <img src="images/shield2.png" alt="Lock Icon" class="lockIcon">
        </header>

        <section class="loginContainer">
            <form class="loginBox" action="register.php" method="post">
                <label class="loginText" for="username">Email or Username:</label>
                <input type="text" id="email;" name="email" required>
            
                <label class="loginText" for="username">Password:</label>
                <input type="password" id="password" name="password" required>

                <input value="Log in" class="loginButton" type="submit" name="logIn">
            </form>

            <h4><a class="signupButton" href="signup.php">Sign up for Crypt</a></h4>
        </section>
    </body>
</html>

<?php

?>