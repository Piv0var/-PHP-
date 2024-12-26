<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_id = htmlspecialchars($_POST['hotel_id']);
    $user_name = htmlspecialchars($_POST['user_name']);
    $comment = htmlspecialchars($_POST['comment']);

    $sql = "INSERT INTO comments (hotel_id, user_name, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $hotel_id, $user_name, $comment);

    if ($stmt->execute()) {
        header("Location: hotelinfo.php?id=" . $hotel_id);
        exit;
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

$hotels_result = $conn->query("SELECT id, name FROM hotels");
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати коментар</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f3f4f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .comment-form {
            background: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 10px;
            padding: 30px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .comment-form h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 22px;
            text-align: center;
        }

        .comment-form select,
        .comment-form input,
        .comment-form textarea,
        .comment-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            font-size: 14px;
        }

        .comment-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .comment-form button {
            background: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .comment-form button:hover {
            background: #0056b3;
        }

        .comment-form select:focus,
        .comment-form input:focus,
        .comment-form textarea:focus,
        .comment-form button:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>
<body>
    <form class="comment-form" action="comments.php" method="POST">
        <h3>Залишити коментар</h3>

        <select name="hotel_id" id="hotel_id" required>
            <option value="" disabled selected>Оберіть готель</option>
            <?php
            if ($hotels_result->num_rows > 0) {
                while ($row = $hotels_result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
            }
            ?>
        </select>

        <input type="text" name="user_name" id="user_name" placeholder="Ваше ім'я" required>
        <textarea name="comment" id="comment" placeholder="Ваш коментар" required></textarea>
        <button type="submit">Відправити</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
