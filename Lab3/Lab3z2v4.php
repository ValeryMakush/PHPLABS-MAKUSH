<?php
// Перевіряємо, чи було відправлено число з форми
if (isset($_POST['number'])) {
    $number = (float)$_POST['number']; // Отримуємо та приводимо до числа
    
    // Тернарний оператор для перевірки
    $result = ($number > 0) 
        ? "Число <strong>$number</strong> є додатним." 
        : "Число <strong>$number</strong> НЕ є додатним (або дорівнює нулю).";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Перевірка числа</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 400px; margin: 0 auto; }
        input, button { padding: 8px; margin: 5px 0; }
        .result { margin-top: 15px; padding: 10px; border-radius: 5px; }
        .positive { background-color: #e6ffe6; }
        .negative { background-color: #ffe6e6; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Перевірка числа на додатність</h2>
        <form method="post">
            <label for="number">Введіть число:</label><br>
            <input type="number" name="number" id="number" step="any" required><br>
            <button type="submit">Перевірити</button>
        </form>

        <?php if (isset($result)): ?>
            <div class="result <?php echo ($number > 0) ? 'positive' : 'negative'; ?>">
                <?php echo $result; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>