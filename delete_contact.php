<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "ss";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $deleteQuery = "DELETE FROM contact WHERE id = $id";

    if (mysqli_query($conn, $deleteQuery)) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error deleting contact: " . mysqli_error($conn);
    }
} else {
    echo "No contact ID provided.";
}
?>