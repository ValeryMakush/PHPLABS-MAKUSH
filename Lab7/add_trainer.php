<?php

// Деталі підключення до бази даних
$servername = "localhost";
$username = "root"; // ВАЖЛИВО: Ваш логін MySQL
$password = "";     // ВАЖЛИВО: Ваш пароль MySQL
$dbname = "gym_management";

$message = ''; // Змінна для зберігання повідомлень про успіх або помилку

// Перевірка, чи була відправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Створення з'єднання
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Перевірка з'єднання
    if ($conn->connect_error) {
        die("Помилка підключення: " . $conn->connect_error);
    }

    // Отримання даних форми та екранування спеціальних символів
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $email = $conn->real_escape_string($_POST['email']);

    // SQL для вставки нового тренера
    $sql = "INSERT INTO trainers (first_name, last_name, phone_number, email)
            VALUES ('$first_name', '$last_name', '$phone_number', '$email')";

    if ($conn->query($sql) === TRUE) {
        $message = "<p style='color: green;'>Тренер <strong>" . htmlspecialchars($first_name . " " . $last_name) . "</strong> успішно доданий!</p>";
    } else {
        if ($conn->errno == 1062) {
            $message = "<p style='color: red;'>Помилка додавання: Тренер з email <strong>" . htmlspecialchars($email) . "</strong> вже існує.</p>";
        } else {
            $message = "<p style='color: red;'>Помилка додавання: " . $conn->error . "</p>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати Тренера</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; color: #333; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        h1 { text-align: center; color: #0056b3; margin-bottom: 30px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="text"], input[type="email"] {
            width: calc(100% - 22px);
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .message p { margin: 0; }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; // <-- ДОДАНО ЦЕЙ РЯДОК ?>
    <div class="container">
        <h1>Додати Нового Тренера</h1>

        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="add_trainer.php" method="POST">
            <label for="first_name">Ім'я:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Прізвище:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="phone_number">Номер телефону:</label>
            <input type="text" id="phone_number" name="phone_number">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Додати Тренера</button>
        </form>
    </div>
</body>
</html>