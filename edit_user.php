<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "athlete_management";

$conn = new mysqli($host, $user, $pass, $dbname);

$id = $_GET['id'];

$sql = "SELECT id, username, full_name, email, role FROM users WHERE id='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

echo json_encode($user);

$conn->close();
