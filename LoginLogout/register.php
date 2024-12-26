<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role']; 
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("SELECT COUNT(*) FROM Users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($userExists);
        $stmt->fetch();
        $stmt->close();

        if ($userExists > 0) {
            $error = "Username already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO Users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $username, $hashedPassword, $role);
            if ($stmt->execute()) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Error: Could not register user.";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h1>Register</h1>
<?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
<?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
<form method="POST">
    <label>Username:</label><input type="text" name="username" required><br>
    <label>Password:</label><input type="password" name="password" required><br>
    <label>Confirm Password:</label><input type="password" name="confirm_password" required><br>
    
    <label>Role:</label>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>
    
    <button type="submit">Register</button>
</form>
<a href="login.php">Back to Login</a>
</body>
</html>
