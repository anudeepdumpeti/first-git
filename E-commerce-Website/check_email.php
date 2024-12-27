<?php
// Include database connection
include 'config.php';

// Default response
$response = array("exists" => false, "message" => "Email not found");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Check if the email exists in the database
    if (!empty($email)) {
        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = array("exists" => true, "message" => "Email exists in the database");
        }

        $stmt->close();
    }
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
