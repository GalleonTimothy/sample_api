<?php
// Include the database connection file
include 'connection.php';

// Set the header to return JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email and password from the request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Return a success response
            echo json_encode(['success' => true, 'user_id' => $user['id']]);
        } else {
            // Invalid password
            echo json_encode(['success' => false, 'message' => 'Invalid password.']);
        }
    } else {
        // No user found with this email
        echo json_encode(['success' => false, 'message' => 'No user found with this email.']);
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>