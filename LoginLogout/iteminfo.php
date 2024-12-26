<?php
include('connect.php');
$item_id = $_GET['id'];
$result = $conn->query("SELECT * FROM Items WHERE id = $item_id");
$item = $result->fetch_assoc();

if (!$item) {
    echo "Item not found.";
    exit;
}

$result = $conn->query("SELECT image_path FROM Images WHERE item_id = $item_id");
$images = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title><?= htmlspecialchars($item['name']) ?></title></head>
<body>
<h1><?= htmlspecialchars($item['name']) ?></h1>
<p><?= htmlspecialchars($item['description']) ?></p>
<h2>Gallery</h2>
<?php if ($images): ?>
    <?php foreach ($images as $image): ?>
        <img src="../assets/<?= htmlspecialchars($image['image_path']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:200px;">
    <?php endforeach; ?>
<?php else: ?>
    <p>No images available.</p>
<?php endif; ?>
</body>
</html>
