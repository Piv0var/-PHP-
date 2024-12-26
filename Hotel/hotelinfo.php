<?php
include('connect.php');

$hotel_id = $_GET['id'];

$hotel_result = $conn->query("SELECT * FROM hotels WHERE id = $hotel_id");
$hotel = $hotel_result->fetch_assoc();

$comments_result = $conn->query("SELECT * FROM comments WHERE hotel_id = $hotel_id");
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $hotel['name']; ?></title>
</head>
<body>
    <h1>Описание: <?php echo $hotel['name']; ?></h1>
    <p><?php echo $hotel['description']; ?></p>

    <h3>Комментарии:</h3>

    <?php
    if ($comments_result->num_rows > 0) {
        while ($comment = $comments_result->fetch_assoc()) {
            echo "<div><strong>" . $comment['user_name'] . ":</strong> " . $comment['comment'] . "</div><hr>";
        }
    } else {
        echo "<p>Нет комментариев.</p>";
    }
    ?>
</body>
</html>
