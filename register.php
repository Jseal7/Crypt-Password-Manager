<?php
include 'database.php';

if(isset($_POST['signUp'])) {
    $userName=$_POST['userName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        echo "<script>alert('Email Address is already in use.'); window.location.href = 'signup.php'; </script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (userName, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $userName, $email, $password);
        if($stmt->execute()) {
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

    $stmt = $conn->prepare("SELECT * FROM users WHERE (email = ? OR userName = ?) AND password = ?");
    $stmt->bind_param("sss", $email, $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email']=$row['email'];
        $_SESSION['user_id']=$row['id'];
        header("Location: mainPage.php");
        exit();
    } else {
        echo "<script>alert('Incorrect Email or Password.'); window.location.href = 'login.php'; </script>";
    }
}

?>