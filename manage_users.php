<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "athlete_management";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search, Filter, and Pagination Variables
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$filterRole = isset($_GET['role']) ? $_GET['role'] : '';
$recordsPerPage = isset($_GET['records']) ? intval($_GET['records']) : 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $recordsPerPage;

// Build the query
$query = "SELECT id, username, full_name, email, role FROM users WHERE 1=1";

// Search by term
if (!empty($searchTerm)) {
    $query .= " AND (username LIKE '%$searchTerm%' OR full_name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%')";
}

// Filter by role
if (!empty($filterRole)) {
    $query .= " AND role = '$filterRole'";
}

// Pagination
$totalQuery = $conn->query($query);
$totalRecords = $totalQuery->num_rows;
$totalPages = ceil($totalRecords / $recordsPerPage);

$query .= " LIMIT $offset, $recordsPerPage";
$result = $conn->query($query);

// Handle form actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        // Add new user
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, full_name, email, role, password) VALUES ('$username', '$full_name', '$email', '$role', '$password')";
        $conn->query($sql);

    } elseif ($action == 'edit') {
        // Edit existing user
        $id = $_POST['user_id'];
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $sql = "UPDATE users SET username='$username', full_name='$full_name', email='$email', role='$role' WHERE id=$id";
        $conn->query($sql);

    } elseif ($action == 'delete') {
        // Delete user
        $id = $_POST['user_id'];
        $sql = "DELETE FROM users WHERE id=$id";
        $conn->query($sql);
    }
}

// Handle partial refresh for search and filter
if (isset($_GET['search']) || isset($_GET['role']) || isset($_GET['page'])) {
    ?>
    <div class="users-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <form method="POST" action="manage_users.php" style="display:inline;">
                                <input type="hidden" name="action" value="edit_form">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="nav-link"><i class="fa fa-edit"></i> Edit</button>
                            </form>
                            <form method="POST" action="manage_users.php" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="nav-link" style="color:red;"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <form method="GET" action="">
            <select name="records" onchange="this.form.submit()">
                <option value="5" <?php echo $recordsPerPage == 5 ? 'selected' : ''; ?>>5 per page</option>
                <option value="10" <?php echo $recordsPerPage == 10 ? 'selected' : ''; ?>>10 per page</option>
                <option value="20" <?php echo $recordsPerPage == 20 ? 'selected' : ''; ?>>20 per page</option>
            </select>
        </form>
        <div class="page-links">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <a href="?search=<?php echo $searchTerm; ?>&role=<?php echo $filterRole; ?>&records=<?php echo $recordsPerPage; ?>&page=<?php echo $i; ?>" class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php } ?>
        </div>
    </div>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Athlete Management System</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-dashboard">
        <div class="main-content">
            <div id="manage_users">
                <div class="top-nav">
                    <h1>Manage Users</h1>
                    <form action="manage_users.php" method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="add_form">
                        <button type="submit" class="btn add-user-btn"><i class="fa fa-user-plus"></i> Add New User</button>
                    </form>
                    <button class="btn" onclick="window.location.href='dashboard_admin.php'">
                        <i class="fa fa-arrow-left"></i> Back to Dashboard
                    </button>
                </div>

                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <form method="GET" action="">
                        <input type="text" name="search" placeholder="Search users by name or email..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                        <select name="role">
                            <option value="">Filter by Role</option>
                            <option value="Coach" <?php echo $filterRole == 'Coach' ? 'selected' : ''; ?>>Coach</option>
                            <option value="Medical" <?php echo $filterRole == 'Medical' ? 'selected' : ''; ?>>Medical</option>
                        </select>
                        <button class="btn search-btn" type="submit">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </form>
                </div>

                <div id="content-area">
                    <?php
                    // Show Add/Edit form
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array($_POST['action'], ['add_form', 'edit_form'])) {
                        $user = null;
                        if ($_POST['action'] == 'edit_form') {
                            $id = $_POST['user_id'];
                            $result = $conn->query("SELECT * FROM users WHERE id=$id");
                            $user = $result->fetch_assoc();
                        }
                        ?>
                        <form action="manage_users.php" method="POST">
                            <input type="hidden" name="action" value="<?php echo $user ? 'edit' : 'add'; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user['id'] ?? ''; ?>">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" value="<?php echo $user['username'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="full_name">Full Name:</label>
                                <input type="text" id="full_name" name="full_name" value="<?php echo $user['full_name'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" value="<?php echo $user['email'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select id="role" name="role" required>
                                    <option value="Coach" <?php echo ($user['role'] ?? '') == 'Coach' ? 'selected' : ''; ?>>Coach</option>
                                    <option value="Medical" <?php echo ($user['role'] ?? '') == 'Medical' ? 'selected' : ''; ?>>Medical</option>
                                </select>
                            </div>
                            <?php if (!$user) { ?>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" name="password" required>
                                </div>
                            <?php } ?>
                            <div class="form-actions">
                                <button type="submit" class="btn save-btn">
                                    <i class="fa fa-save"></i> <?php echo $user ? 'Update User' : 'Add User'; ?>
                                </button>
                                <button type="button" class="btn cancel-btn" onclick="window.location.href='manage_users.php'">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    <?php } else { ?>
                        <!-- Users Table (content is dynamically loaded based on search/filter) -->
                        <div class="users-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['full_name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['role']; ?></td>
                                            <td>
                                                <form method="POST" action="manage_users.php" style="display:inline;">
                                                    <input type="hidden" name="action" value="edit_form">
                                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="nav-link"><i class="fa fa-edit"></i> Edit</button>
                                                </form>
                                                <form method="POST" action="manage_users.php" style="display:inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="nav-link" style="color:red;"><i class="fa fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination">
                            <form method="GET" action="">
                                <select name="records" onchange="this.form.submit()">
                                    <option value="5" <?php echo $recordsPerPage == 5 ? 'selected' : ''; ?>>5 per page</option>
                                    <option value="10" <?php echo $recordsPerPage == 10 ? 'selected' : ''; ?>>10 per page</option>
                                    <option value="20" <?php echo $recordsPerPage == 20 ? 'selected' : ''; ?>>20 per page</option>
                                </select>
                            </form>
                            <div class="page-links">
                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                    <a href="?search=<?php echo $searchTerm; ?>&role=<?php echo $filterRole; ?>&records=<?php echo $recordsPerPage; ?>&page=<?php echo $i; ?>" class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
