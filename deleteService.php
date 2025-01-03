<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to delete a service.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceName = $_POST['service_name'];
    $strongPassword = $_POST['strong_password'];
    $userId = $_SESSION['user_id'];

    $query = "DELETE FROM services WHERE user_id = ? AND service_name = ? AND strong_password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $userId, $serviceName, $strongPassword);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Service deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete service.']);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
