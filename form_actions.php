<?php
// form_actions.php
include 'db_connection.php';
include 'user_form_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add_form') {
        showAddUserForm();
    } elseif ($action == 'add_user') {
        $username = $_POST['username'];
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, full_name, email, role, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $fullName, $email, $role, $password);
        $stmt->execute();

        echo "<div class='message success'>User added successfully!</div>";
        $stmt->close();
    }
}
