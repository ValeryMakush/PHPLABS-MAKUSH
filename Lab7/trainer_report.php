<?php

// Database connection details
$servername = "localhost";
$username = "root"; // IMPORTANT: Your MySQL username
$password = "";     // IMPORTANT: Your MySQL password
$dbname = "gym_management";

$trainers_data = []; // Array to store report data
$message = ''; // Variable to store error messages

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the count of trainings per trainer
$sql = "
SELECT
    t.first_name,
    t.last_name,
    COUNT(tr.training_id) AS total_trainings
FROM
    trainers AS t
LEFT JOIN
    trainings AS tr ON t.trainer_id = tr.trainer_id
GROUP BY
    t.trainer_id, t.first_name, t.last_name
ORDER BY
    total_trainings DESC;
";

$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Fetch all results
        while($row = $result->fetch_assoc()) {
            $trainers_data[] = $row;
        }
    } else {
        $message = "<p>Немає даних про тренерів або тренування.</p>";
    }
} else {
    $message = "<p style='color: red;'>Помилка при отриманні звіту: " . $conn->error . "</p>";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Звіт про тренування тренерів</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; color: #333; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 800px; margin: auto; }
        h1 { text-align: center; color: #0056b3; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e0e0e0; padding: 12px; text-align: left; }
        th { background-color: #e9ecef; color: #495057; font-weight: bold; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #e2e6ea; }
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; // <-- ДОДАНО ЦЕЙ РЯДОК ?>
    <div class="container">
        <h1>Звіт про кількість тренувань, проведених кожним тренером</h1>

        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($trainers_data)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Ім'я тренера</th>
                        <th>Прізвище тренера</th>
                        <th>Кількість тренувань</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trainers_data as $trainer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($trainer['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($trainer['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($trainer['total_trainings']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>