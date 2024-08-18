<?php
include('db_connection.php');

// Sample users
$users = [
    ['username' => 'admin_user', 'full_name' => 'Admin User', 'email' => 'admin@example.com', 'password' => password_hash('Admin@123', PASSWORD_BCRYPT), 'role' => 'admin'],
    ['username' => 'coach_user', 'full_name' => 'Coach User', 'email' => 'coach@example.com', 'password' => password_hash('Coach@123', PASSWORD_BCRYPT), 'role' => 'coach'],
    ['username' => 'medical_user', 'full_name' => 'Medical User', 'email' => 'medical@example.com', 'password' => password_hash('Medical@123', PASSWORD_BCRYPT), 'role' => 'medical']
];

foreach ($users as $user) {
    $stmt = $conn->prepare("INSERT INTO users (username, full_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $user['username'], $user['full_name'], $user['email'], $user['password'], $user['role']);
    $stmt->execute();
    echo "Inserted user: " . $user['username'] . "\n";
}

echo "All users have been inserted successfully.";
?>
