<?php
// report.php - This file displays the project report information.
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Звіт про виконання</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; color: #333; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 800px; margin: auto; line-height: 1.6; }
        h1 { text-align: center; color: #0056b3; margin-bottom: 30px; }
        h2 { color: #0056b3; margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        ul { list-style-type: disc; margin-left: 20px; }
        li { margin-bottom: 8px; }
        strong { color: #555; }
        pre {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: Consolas, monospace;
            font-size: 0.9em;
            white-space: pre-wrap; /* Ensures long lines wrap */
            word-wrap: break-word; /* Ensures long words break */
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; // Включаємо навігаційне меню ?>

    <div class="container">
        <h1>Звіт про виконання Лабораторної роботи №7</h1>

        <h2>1. Особисті дані</h2>
        <ul>
            <li><strong>ПІБ:</strong> [Ваше Прізвище Ім'я По батькові]</li>
            <li><strong>Група:</strong> [Ваша Група]</li>
            <li><strong>Дата виконання / здачі:</strong> 2025-06-05</li>
            <li><strong>Номер варіанту:</strong> [Ваш Номер Варіанту]</li>
        </ul>

        <h2>2. Умова завдання</h2>
        <pre>
Система управління тренажерним залом
1. Створити базу даних MySQL для зберігання інформації про клієнтів, абонементи та тренування.
2. Реалізувати інтерфейс для реєстрації нових клієнтів.
3. Відобразити звіт про кількість тренувань, проведених кожним тренером.
(Додаткові вимоги:
- Додати інтерфейс для додавання тренерів.
- Додати інтерфейс для запису тренувань.
- Додати навігацію між сторінками.
- Оформити звіт із зазначенням ПІБ, групи, дати виконання/здачі, номера варіанту та номера й умови завдань.)
        </pre>

        <h2>3. Використані файли та їх призначення</h2>
        <ul>
            <li><code>create_database.php</code>: Створює базу даних `gym_management` та необхідні таблиці (`clients`, `memberships`, `trainers`, `trainings`).</li>
            <li><code>register_client.php</code>: Веб-інтерфейс для реєстрації нових клієнтів у базі даних.</li>
            <li><code>add_trainer.php</code>: Веб-інтерфейс для додавання нових тренерів у базі даних.</li>
            <li><code>add_training.php</code>: Веб-інтерфейс для запису тренувань, пов'язуючи клієнтів та тренерів.</li>
            <li><code>trainer_report.php</code>: Відображає звіт про кількість тренувань, проведених кожним тренером.</li>
            <li><code>index.php</code>: Головна сторінка системи з навігаційними посиланнями та кнопкою "Звіт".</li>
            <li><code>includes/navigation.php</code>: PHP-файл, який містить спільне навігаційне меню для всіх сторінок.</li>
            <li><code>report.php</code>: Цей звітний файл з інформацією про проект та студента.</li>
        </ul>

        <h2>4. Додаткові коментарі та висновки</h2>
        <p>
            [Тут ви можете написати свої висновки, що було зроблено, які складнощі виникли,
            як вони були подолані, або будь-які інші важливі коментарі щодо вашої роботи.]
            <br>
            Наприклад: "Під час виконання роботи було реалізовано повний цикл взаємодії з базою даних MySQL за допомогою PHP.
            Особливу увагу приділено валідації даних та обробці помилок, а також забезпеченню зручності навігації."
        </p>
    </div>
</body>
</html>