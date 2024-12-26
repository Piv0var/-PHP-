<?php
include('connect.php');

$categories = $conn->query("SELECT * FROM Categories")->fetch_all(MYSQLI_ASSOC);

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

if ($category_id) {
    $stmt = $conn->prepare("SELECT * FROM Items WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM Items");
    $items = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Catalog</title>
</head>
<body>
    <h1>Catalog</h1>
    <h2>Categories</h2>
    <ul>
        <li><a href="catalog.php">All</a></li>
        <?php foreach ($categories as $category): ?>
            <li><a href="catalog.php?category_id=<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <h2>Items</h2>
    <?php if ($items): ?>
        <?php foreach ($items as $item): ?>
            <h3><a href="iteminfo.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></a></h3>
            <p><?= htmlspecialchars($item['description']) ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No items found in this category.</p>
    <?php endif; ?>
</body>
</html>
