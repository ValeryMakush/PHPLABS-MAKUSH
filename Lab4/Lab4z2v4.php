<?php
// Функція для обчислення суми елементів масиву
function sumArray($array) {
    $sum = 0;
    foreach ($array as $number) {
        $sum += $number;
    }
    return $sum;
}

// Створюємо масив чисел від 1 до 20
$numbers = range(1, 20);

// Обчислюємо суму
$total = sumArray($numbers);

// Виводимо результат
echo "Сума чисел від 1 до 20: " . $total;
?>