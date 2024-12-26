<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location:login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Panel</title></head>
<body>
<h1>Admin Panel</h1>
<a href="add_category.php">Add Category</a><br>
<a href="upload_image.php">Upload Images</a>
</body>
</html>
