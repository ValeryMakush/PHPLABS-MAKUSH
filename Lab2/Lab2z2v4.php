<?php
// Приклад перетворення числа в рядок та об'єднання зі словом

// Вихідне число
$number = 42;

// Перетворення числа в рядок
$numberAsString = strval($number); // або (string)$number;

// Слово для об'єднання
$word = " apples";

// Об'єднання рядка числа зі словом
$result = $numberAsString . $word;

// Виведення результатів
echo "Оригінальне число: " . $number . "<br>";
echo "Тип оригінального числа: " . gettype($number) . "<br>";
echo "Число як рядок: " . $numberAsString . "<br>";
echo "Тип після перетворення: " . gettype($numberAsString) . "<br>";
echo "Результат об'єднання: " . $result . "<br>";
?>