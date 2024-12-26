<?php
include('connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $stmt = $conn->prepare("INSERT INTO Categories (name) VALUES (?)");
    $stmt->bind_param('s', $name);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Category added successfully.";
    } else {
        echo "Error: Could not add category.";
    }

    $stmt->close();
}
?>
<form method="POST">
    <label>Category Name:</label>
    <input type="text" name="name" required>
    <br>
    <button type="submit">Add</button>
</form>
