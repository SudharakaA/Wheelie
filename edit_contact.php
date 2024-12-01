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
    $query = "SELECT * FROM contact WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $contact = mysqli_fetch_assoc($result);
    } else {
        echo "Contact not found.";
        exit;
    }
}

// Update contact on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $updateQuery = "UPDATE contact SET f_name='$f_name', email='$email', phone='$phone', dob='$dob', message='$message' WHERE id=$id";
    if (mysqli_query($conn, $updateQuery)) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error updating contact: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
</head>
<body>
    <h2>Edit Contact</h2>
    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="f_name" value="<?php echo htmlspecialchars($contact['f_name']); ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required><br>
        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($contact['phone']); ?>" required><br>
        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?php echo htmlspecialchars($contact['dob']); ?>" required><br>
        <label>Message:</label>
        <textarea name="message" required><?php echo htmlspecialchars($contact['message']); ?></textarea><br>
        <button type="submit">Update</button>
        <a href="dashboard.php">Cancel</a>
    </form>
</body>
</html>