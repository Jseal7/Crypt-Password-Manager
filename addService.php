<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    echo "Error: You must be logged in to add a service.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceName = $_POST['service'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $strongPassword = $_POST['strong_password'];
    $userId = $_SESSION['user_id'];

    $insertQuery = "INSERT INTO services(user_id, service_name, email, username, strong_password) VALUES ('$userId', '$serviceName', '$email', '$username', '$strongPassword')";

    if($conn->query($insertQuery) == TRUE) {
        header("location: mainPage.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'mainPage.php'; </script>";
    }
}
?>