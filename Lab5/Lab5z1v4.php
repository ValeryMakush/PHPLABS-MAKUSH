<?php
// Заборонене слово
$forbiddenWord = 'spam';

// Перевіряємо, чи був переданий текст
if (isset($_GET['text'])) {
    $text = $_GET['text'];
    
    // Перевіряємо наявність забороненого слова (без урахування регістру)
    $containsSpam = stripos($text, $forbiddenWord) !== false;
    
    // Формуємо повідомлення
    $message = $containsSpam 
        ? "Текст містить заборонене слово '$forbiddenWord'!"
        : "Текст не містить заборонених слів.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Перевірка тексту на заборонені слова</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        textarea { width: 100%; padding: 8px; margin: 10px 0; }
        .warning { color: red; font-weight: bold; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Перевірка тексту на заборонені слова</h2>
        <form method="GET">
            <label for="text">Введіть текст:</label><br>
            <textarea name="text" id="text" rows="5" required><?php 
                echo isset($_GET['text']) ? htmlspecialchars($_GET['text']) : ''; 
            ?></textarea><br>
            <button type="submit">Перевірити</button>
        </form>

        <?php if (isset($message)): ?>
            <p class="<?php echo $containsSpam ? 'warning' : 'success'; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>
    </div>
</body>
</html>