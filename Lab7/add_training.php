<?php

// Деталі підключення до бази даних
$servername = "localhost";
$username = "root"; // ВАЖЛИВО: Ваш логін MySQL
$password = "";     // ВАЖЛИВО: Ваш пароль MySQL
$dbname = "gym_management";

$message = ''; // Змінна для зберігання повідомлень
$clients = []; // Масив для зберігання клієнтів
$trainers = []; // Масив для зберігання тренерів

// Створення з'єднання
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// --- Завантаження Клієнтів для спадного списку ---
$sql_clients = "SELECT client_id, first_name, last_name FROM clients ORDER BY last_name, first_name";
$result_clients = $conn->query($sql_clients);
if ($result_clients->num_rows > 0) {
    while($row = $result_clients->fetch_assoc()) {
        $clients[] = $row;
    }
}

// --- Завантаження Тренерів для спадного списку ---
$sql_trainers = "SELECT trainer_id, first_name, last_name FROM trainers ORDER BY last_name, first_name";
$result_trainers = $conn->query($sql_trainers);
if ($result_trainers->num_rows > 0) {
    while($row = $result_trainers->fetch_assoc()) {
        $trainers[] = $row;
    }
}

// --- Обробка відправки форми Тренування ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних форми та екранування
    $client_id = $conn->real_escape_string($_POST['client_id']);
    $trainer_id = $conn->real_escape_string($_POST['trainer_id']);
    $training_date = $conn->real_escape_string($_POST['training_date']);
    $training_time = $conn->real_escape_string($_POST['training_time']);
    $duration_minutes = $conn->real_escape_string($_POST['duration_minutes']);
    $notes = $conn->real_escape_string($_POST['notes']);

    // SQL для вставки нового тренування
    $sql_insert_training = "INSERT INTO trainings (client_id, trainer_id, training_date, training_time, duration_minutes, notes)
                            VALUES ('$client_id', '$trainer_id', '$training_date', '$training_time', '$duration_minutes', '$notes')";

    if ($conn->query($sql_insert_training) === TRUE) {
        $message = "<p style='color: green;'>Тренування успішно записано!</p>";
    } else {
        $message = "<p style='color: red;'>Помилка запису тренування: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записати Тренування</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; color: #333; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        h1 { text-align: center; color: #0056b3; margin-bottom: 30px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="date"], input[type="time"], input[type="number"], textarea, select {
            width: calc(100% - 22px);
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #17a2b8;
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
            background-color: #138496;
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
        <h1>Записати Нове Тренування</h1>

        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($clients)): ?>
            <p style="color: orange; text-align: center;">Будь ласка, спочатку додайте клієнтів через <a href="register_client.php">форму реєстрації клієнтів</a>.</p>
        <?php endif; ?>

        <?php if (empty($trainers)): ?>
            <p style="color: orange; text-align: center;">Будь ласка, спочатку додайте тренерів через <a href="add_trainer.php">форму додавання тренерів</a>.</p>
        <?php endif; ?>

        <?php if (!empty($clients) && !empty($trainers)): ?>
            <form action="add_training.php" method="POST">
                <label for="client_id">Клієнт:</label>
                <select id="client_id" name="client_id" required>
                    <option value="">Виберіть клієнта</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo htmlspecialchars($client['client_id']); ?>">
                            <?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="trainer_id">Тренер:</label>
                <select id="trainer_id" name="trainer_id" required>
                    <option value="">Виберіть тренера</option>
                    <?php foreach ($trainers as $trainer): ?>
                        <option value="<?php echo htmlspecialchars($trainer['trainer_id']); ?>">
                            <?php echo htmlspecialchars($trainer['first_name'] . ' ' . $trainer['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="training_date">Дата тренування:</label>
                <input type="date" id="training_date" name="training_date" required>

                <label for="training_time">Час тренування:</label>
                <input type="time" id="training_time" name="training_time" required>

                <label for="duration_minutes">Тривалість (хвилини):</label>
                <input type="number" id="duration_minutes" name="duration_minutes" min="15" max="240" step="15" value="60">

                <label for="notes">Нотатки:</label>
                <textarea id="notes" name="notes" rows="4"></textarea>

                <button type="submit">Записати Тренування</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>