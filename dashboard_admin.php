<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Athlete Management System</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <ul class="nav">
                <li><a href="#" onclick="loadContent('dashboard.html')"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#" onclick="loadContent('manage_users.php')"><i class="fa fa-users"></i> Manage Users</a></li>
                <li><a href="#" onclick="loadContent('manage_events.html')"><i class="fa fa-calendar-alt"></i> Manage Events</a></li>
                <li><a href="#" onclick="loadContent('manage_training.html')"><i class="fa fa-dumbbell"></i> Manage Training</a></li>
                <li><a href="#" onclick="loadContent('manage_medical.html')"><i class="fa fa-heartbeat"></i> Manage Medical</a></li>
                <li><a href="#" onclick="loadContent('system_settings.html')"><i class="fa fa-cogs"></i> System Settings</a></li>
                <li><a href="#"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="top-nav">
                <div class="welcome">
                    <h1>Welcome, Admin</h1>
                </div>
                <div class="top-buttons">
                    <button class="btn"><i class="fa fa-bell"></i> Notifications</button>
                    <button class="btn"><i class="fa fa-user-circle"></i> Profile</button>
                    <button class="btn"><i class="fa fa-cog"></i> Settings</button>
                    <button class="btn logout"><i class="fa fa-sign-out-alt"></i> Logout</button>
                </div>
            </div>

            <div class="content" id="content-area">
                <h2>Dashboard Overview</h2>
                <!-- Placeholder for additional content -->
            </div>
        </div>
    </div>

    <script>
        // Function to dynamically load content into the main content area
        function loadContent(page) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content-area").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", page, true);
            xhttp.send();
        }
    </script>
</body>
</html>
