<?php
include('connect.php');

$categories = $conn->query("SELECT * FROM Categories")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("INSERT INTO Items (name, description, category_id) VALUES (?, ?, ?)");
    $stmt->bind_param('ssi', $name, $description, $category_id);
    if ($stmt->execute()) {
        echo "Item added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<form method="POST">
    <label>Item Name:</label><input type="text" name="name" required><br>
    <label>Description:</label><textarea name="description" required></textarea><br>
    <label>Category:</label>
    <select name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Add Item</button>
</form>
