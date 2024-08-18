<?php
// user_query_display.php
include 'db_connection.php';
include 'search_filter_pagination.php';

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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['full_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>";
        echo "<form method='POST' action='manage_users.php' style='display:inline;'>";
        echo "<input type='hidden' name='action' value='edit_form'>";
        echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' class='nav-link'><i class='fa fa-edit'></i> Edit</button>";
        echo "</form> ";
        echo "<form method='POST' action='manage_users.php' style='display:inline;'>";
        echo "<input type='hidden' name='action' value='delete'>";
        echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' class='nav-link' style='color:red;'><i class='fa fa-trash'></i> Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No users found.</td></tr>";
}
?>
