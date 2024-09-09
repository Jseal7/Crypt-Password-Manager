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
            <h2>Sign up to Crypt</h2>
            <img src="images/shield2.png" alt="Lock Icon" class="lockIcon">
        </header>

        <section class="loginContainer" id="signUp">
            <form class="loginBox" action="register.php" method="post">
                <label class="loginText">Email:</label>
                <input type="text" id="email" name="email" required>
            
                <label class="loginText">Username:</label>
                <input type="text" id="userName" name="userName" required>
            
                <label class="loginText">Password:</label>
                <input type="password" id="password" name="password" required>

                <input value="Sign Up" class="loginButton" type="submit" name="signUp">
            </form>

            <h4><a class="signupButton" href="login.php">Log in to Crypt</a></h4>
        </section>
    </body>
</html>