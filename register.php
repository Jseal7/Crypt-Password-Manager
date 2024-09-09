<?php

include 'database.php';

if(isset($_POST['signUp'])) {
    $userName=$_POST['userName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $checkEmail="SELECT * FROM users WHERE email='$email'";
    $result=$conn->query($checkEmail);
    if($result->num_rows > 0) {
        echo "<script>alert('Email Address is already in use.'); window.location.href = 'signup.php'; </script>";
    } else {
        $insertQuery="INSERT INTO users(userName, email, password) VALUES ('$userName','$email','$password')";
        if($conn->query($insertQuery) == TRUE) {
            header("location: login.php");
        } else {
            echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'signup.php'; </script>";
        }
    }
}

if(isset($_POST['logIn'])) {
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $sql="SELECT * FROM users WHERE (email='$email' OR userName='$email') AND password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email']=$row['email'];
        header("Location: mainPage.php");
        exit();
    } else {
        echo "<script>alert('Incorrect Email or Password.'); window.location.href = 'login.php'; </script>";
    }
}

?>