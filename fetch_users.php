<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "athlete_management";

$conn = new mysqli($host, $user, $pass, $dbname);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$role = isset($_GET['role']) ? $_GET['role'] : '';

$sql = "SELECT id, username, full_name, email, role FROM users WHERE (username LIKE '%$search%' OR email LIKE '%$search%')";
if ($role) {
    $sql .= " AND role='$role'";
}
$sql .= " ORDER BY id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['full_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>";
        echo "<button class='btn edit-btn' data-id='" . $row['id'] . "'>Edit</button>";
        echo "<button class='btn delete-btn' data-id='" . $row['id'] . "'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No users found</td></tr>";
}

$conn->close();

