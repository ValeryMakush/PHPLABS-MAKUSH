<?php

// Database connection details
$servername = "localhost";
$username = "root"; // IMPORTANT: Your MySQL username
$password = "";     // IMPORTANT: Your MySQL password
$dbname = "gym_management";

$message = ''; // Variable to store success or error messages

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection for errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data and escape special characters to prevent SQL injection
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $email = $conn->real_escape_string($_POST['email']);

    // SQL query to insert new client data into the 'clients' table
    $sql = "INSERT INTO clients (first_name, last_name, date_of_birth, phone_number, email)
            VALUES ('$first_name', '$last_name', '$date_of_birth', '$phone_number', '$email')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        $message = "<p style='color: green;'>Клієнт <strong>" . htmlspecialchars($first_name . " " . $last_name) . "</strong> успішно зареєстрований!</p>";
    } else {
        if ($conn->errno == 1062) {
            $message = "<p style='color: red;'>Помилка реєстрації: Клієнт з email <strong>" . htmlspecialchars($email) . "</strong> вже існує.</p>";
        } else {
            $message = "<p style='color: red;'>Помилка реєстрації: " . $conn->error . "</p>";
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
    <title>Реєстрація Нового Клієнта</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; color: #333; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        h1 { text-align: center; color: #0056b3; margin-bottom: 30px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="text"], input[type="date"], input[type="email"] {
            width: calc(100% - 22px);
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #28a745;
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
            background-color: #218838;
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
        <h1>Реєстрація Нового Клієнта</h1>

        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="register_client.php" method="POST">
            <label for="first_name">Ім'я:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Прізвище:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="date_of_birth">Дата народження:</label>
            <input type="date" id="date_of_birth" name="date_of_birth">

            <label for="phone_number">Номер телефону:</label>
            <input type="text" id="phone_number" name="phone_number">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Зареєструвати</button>
        </form>
    </div>
</body>
</html>