<?php
session_start();
include('db_connection.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to prevent SQL injection
    $query = $conn->prepare("SELECT * FROM users WHERE username=?");
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password using bcrypt
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header('Location: dashboard_admin.php');
            } elseif ($user['role'] == 'coach') {
                header('Location: dashboard_coach.php');
            } elseif ($user['role'] == 'medical') {
                header('Location: dashboard_medical.php');
            }
        } else {
            $error = 'Invalid username or password!';
        }
    } else {
        $error = 'Invalid username or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Login - Athlete Management System</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <i class="fa fa-user icon"></i>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <i class="fa fa-key icon"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fa fa-eye" id="toggleIcon" onclick="togglePassword()"></i>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
