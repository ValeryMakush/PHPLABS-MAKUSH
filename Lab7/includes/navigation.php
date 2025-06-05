<?php
// includes/navigation.php - This file contains the navigation menu for the gym management system.
?>
<nav style="background-color: #333; padding: 10px 0; text-align: center;">
    <ul style="list-style-type: none; margin: 0; padding: 0;">
        <li style="display: inline-block; margin: 0 15px;">
            <a href="register_client.php" style="color: white; text-decoration: none; font-weight: bold;">Реєстрація Клієнта</a>
        </li>
        <li style="display: inline-block; margin: 0 15px;">
            <a href="add_trainer.php" style="color: white; text-decoration: none; font-weight: bold;">Додати Тренера</a>
        </li>
        <li style="display: inline-block; margin: 0 15px;">
            <a href="add_training.php" style="color: white; text-decoration: none; font-weight: bold;">Записати Тренування</a>
        </li>
        <li style="display: inline-block; margin: 0 15px;">
            <a href="trainer_report.php" style="color: white; text-decoration: none; font-weight: bold;">Звіт по Тренерам</a>
        </li>
        <li style="display: inline-block; margin: 0 15px;">
            <a href="create_database.php" style="color: white; text-decoration: none; font-weight: bold;" onclick="return confirm('Ви впевнені? Це перезапустить базу даних, якщо вона вже існує.');">Створити БД (Обновити)</a>
        </li>
    </ul>
</nav>
<div style="height: 20px;"></div> 
