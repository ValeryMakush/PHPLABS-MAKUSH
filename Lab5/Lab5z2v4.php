<?php
$phone = '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    
    // Перевірка 1: Чи не порожній ввід
    if (empty($phone)) {
        $error = "Будь ласка, введіть номер телефону";
    } 
    // Перевірка 2: Чи містить лише цифри та можливий + на початку
    elseif (!preg_match('/^\+?\d+$/', $phone)) {
        // Знаходимо всі недопустимі символи
        preg_match_all('/[^\d+]/', $phone, $matches);
        $invalidChars = array_unique($matches[0]);
        $error = "Номер містить недопустимі символи: " . implode(', ', $invalidChars);
    } 
    // Перевірка 3: Довжина номера (прибрали + для перевірки)
    elseif (strlen(preg_replace('/\D/', '', $phone)) < 10) {
        $error = "Занадто короткий номер. Має бути щонайменше 10 цифр";
    } 
    // Якщо все валідно
    else {
        $success = "Номер валідний: " . htmlspecialchars($phone);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Перевірка номера телефону</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 400px; margin: 0 auto; }
        input, button { padding: 8px; margin: 5px 0; width: 100%; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Перевірка номера телефону</h2>
        <form method="POST">
            <label for="phone">Введіть номер (тільки цифри, можливий + на початку):</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" 
                   placeholder="+380123456789" required>
            <button type="submit">Перевірити</button>
        </form>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php elseif ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
    </div>
</body>
</html>