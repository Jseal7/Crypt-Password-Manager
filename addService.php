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
    $userId = $_SESSION['user_id'];

    function strongPass() {
        $chars = [
            'abcdefghijklmnopqrstuvwxyz',
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            '0123456789',
            '(_-<>!@#$%^&)+='
        ];
        
        $length = rand(8, 12);
        $strongPassword = '';
    
        for ($i = 0; $i < $length; $i++) {
            $arrInd = rand(0, count($chars) - 1);
            $charInd = rand(0, strlen($chars[$arrInd]) - 1);
            $strongPassword .= $chars[$arrInd][$charInd];
        }
    
        return $strongPassword;
    }
    
    $strongPassword = strongPass();

    $insertQuery = "INSERT INTO services(user_id, service_name, email, username, strong_password) VALUES ('$userId', '$serviceName', '$email', '$username', '$strongPassword')";

    if($conn->query($insertQuery) == TRUE) {
        header("location: mainPage.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'mainPage.php'; </script>";
    }
}
?>