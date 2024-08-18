<?php
// show_add_user_form.php
function showAddUserForm() {
    ?>
    <div class="add-user-form">
        <h2>Add New User</h2>
        <form method="POST" action="manage_users.php">
            <input type="hidden" name="action" value="add_user">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Coach">Coach</option>
                    <option value="Medical">Medical</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn submit-btn"><i class="fa fa-save"></i> Add User</button>
            <button type="button" class="btn cancel-btn" onclick="window.location.href='manage_users.php'"><i class="fa fa-times"></i> Cancel</button>
        </form>
    </div>
    <?php
}
?>
