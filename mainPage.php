<?php 
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$query = "SELECT service_name, email, username, strong_password FROM services WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$services = [];
while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crypt</title>
        <link rel="stylesheet" href="mainPage.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
        <script>
            const userServices = <?php echo json_encode($services); ?>;
        </script>
    </head>

    <body>
        <header class="topBar">
            <a href="login.php"><img src="images/user.png" alt="userProfile" class="userProfile"></a>
            <h4 class="title">Crypt</h4>
        </header>
        
        <div class="scrollContainer">
            
        </div>

        <footer class="bottomContainer" id="addButton">
            <input value="Add New" class="addButton" type="submit" name="addNew">
        </footer>

        <div id="popUp" class="popUp">
            <div class="popUpContent" id="popUpContent">
                <span class="closeButton">&times;</span>
                <h2 class="popUpTitle">Add New Service</h2>
                <form id="popUpForm" action="addService.php" method="post">
                    <label for="service">Service:</label>
                    <input type="text" id="service" name="service" required>

                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" required>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <input value="Add Service" type="submit" id="popUpSubmit" class="popUpSubmit" name="popUpSubmit">
                </form>
            </div>
        </div>

        <script src="mainPage.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    </body>
</html>