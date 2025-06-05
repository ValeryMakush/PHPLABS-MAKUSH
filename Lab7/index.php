<?php
// index.php - This file serves as the entry point for your gym management system.
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управління тренажерним залом</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; color: #333; display: flex; flex-direction: column; min-height: 95vh;}
        .content { flex-grow: 1; display: flex; justify-content: center; align-items: center; text-align: center; }
        h1 { color: #0056b3; margin-bottom: 20px; }
        p { font-size: 1.1em; }
        .links a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .links a:hover {
            background-color: #0056b3;
        }
        /* New style for the "Звіт" button */
        .report-button {
            background-color: #6c757d; /* Gray color */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 30px; /* Space above */
            display: inline-block;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .report-button:hover {
            background-color: #5a6268; /* Darker gray on hover */
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="content">
        <div>
            <h1>Ласкаво просимо до Системи управління тренажерним залом!</h1>
            <p>Використовуйте навігаційне меню вище, щоб перейти до потрібного розділу:</p>
            <div class="links">
                <a href="register_client.php">Реєстрація Клієнта</a>
                <a href="add_trainer.php">Додати Тренера</a>
                <a href="add_training.php">Записати Тренування</a>
                <a href="trainer_report.php">Звіт по Тренерам</a>
                <br><br>
                <a href="create_database.php" onclick="return confirm('Ви впевнені? Це перезапустить базу даних, якщо вона вже існує.');">Створити/Оновити Базу Даних</a>
            </div>

            <a href="index.html" class="report-button">Звіт про виконання</a> </div>
    </div>
</body>
</html>