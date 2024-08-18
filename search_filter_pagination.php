<?php
include 'db_connection.php';


// search_filter_pagination.php
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$filterRole = isset($_GET['role']) ? $_GET['role'] : '';
$recordsPerPage = isset($_GET['records']) ? intval($_GET['records']) : 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $recordsPerPage;
