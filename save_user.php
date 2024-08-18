<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "athlete_management";

$conn = new mysqli($host, $user, $pass, $dbname);

$id = $_POST['user_id'];
$username = $_POST['username'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$role = $_POST['role'];
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

if ($id) {
    // Update user
    if ($password) {
        $sql = "UPDATE users SET username='$username', full_name='$full_name', email='$email', role='$role', password='$password' WHERE id='$id'";
    } else {
        $sql = "UPDATE users SET username='$username', full_name='$full_name', email='$email', role='$role' WHERE id='$id'";
    }
} else {
    // Add new user
    $sql = "INSERT INTO users (username, full_name, email, role, password) VALUES ('$username', '$full_name', '$email', '$role', '$password')";
}

$conn->query($sql);
$conn->close();
?>
