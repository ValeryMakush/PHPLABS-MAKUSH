<?php
$servername = "localhost";
$username = "root";  // замініть на вашого користувача
$password = "";      // замініть на ваш пароль
$dbname = "EmployeeManagement";

try {
    // 1. Підключення до сервера MySQL та створення бази даних
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Створення бази даних
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->exec($sql);
    echo "<p>Базу даних <strong>$dbname</strong> успішно створено або вона вже існує</p>";
    
    // 2. Підключення до створеної бази даних
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 3. Створення таблиці Employees
    $sql = "CREATE TABLE IF NOT EXISTS Employees (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        position VARCHAR(100) NOT NULL,
        salary DECIMAL(10, 2) NOT NULL
    )";
    $conn->exec($sql);
    echo "<p>Таблицю <strong>Employees</strong> успішно створено або вона вже існує</p>";
    
    // 4. Очищення таблиці перед додаванням нових даних (опціонально)
    $conn->exec("TRUNCATE TABLE Employees");
    
    // 5. Додавання тестових даних
    $employees = [
        ['Іван Петренко', 'Менеджер', 25000.00],
        ['Олена Сидорова', 'Розробник', 30000.50],
        ['Михайло Коваленко', 'Дизайнер', 22000.75],
        ['Наталія Шевченко', 'Тестувальник', 28000.00],
        ['Андрій Іванов', 'Системний адміністратор', 32000.25],
        ['Тетяна Мельник', 'HR-менеджер', 23000.00],
        ['Вікторія Лисенко', 'Маркетолог', 26000.50],
        ['Олексій Павленко', 'Бухгалтер', 27000.00]
    ];
    
    $stmt = $conn->prepare("INSERT INTO Employees (name, position, salary) VALUES (:name, :position, :salary)");
    
    foreach ($employees as $employee) {
        $stmt->execute([
            ':name' => $employee[0],
            ':position' => $employee[1],
            ':salary' => $employee[2]
        ]);
    }
    echo "<p>Успішно додано " . count($employees) . " записів до таблиці Employees</p>";
    
    // 6. Виведення даних для перевірки
    echo "<h2>Список працівників</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<thead><tr style='background-color: #f2f2f2;'>
            <th>ID</th>
            <th>Ім'я</th>
            <th>Посада</th>
            <th>Зарплата</th>
          </tr></thead>";
    echo "<tbody>";
    
    $stmt = $conn->query("SELECT * FROM Employees ORDER BY id");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
        echo "<td>" . number_format($row['salary'], 2, '.', ' ') . " ₴</td>";
        echo "</tr>";
    }
    
    echo "</tbody></table>";
    
    // 7. Підрахунок суми зарплат
    $stmt = $conn->query("SELECT SUM(salary) as total_salary FROM Employees");
    $total = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p style='margin-top: 20px; font-weight: bold;'>Загальний фонд зарплат: " . 
         number_format($total['total_salary'], 2, '.', ' ') . " ₴</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Помилка: " . $e->getMessage() . "</p>";
}

$conn = null;
?>