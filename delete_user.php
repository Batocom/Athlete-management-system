<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "athlete_management";

$conn = new mysqli($host, $user, $pass, $dbname);

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id='$id'";
$conn->query($sql);

$conn->close();
