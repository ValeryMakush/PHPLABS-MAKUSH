<?php
// Масив чисел від 1 до 10
$numbers = range(1, 10);

// Число, для якого будуємо таблицю множення
$multiplier = 5;

echo "Таблиця множення числа $multiplier:<br>";
echo "-----------------------------<br>";

foreach ($numbers as $number) {
    $result = $multiplier * $number;
    echo "$multiplier × $number = $result <br>";
}
?>