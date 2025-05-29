<?php
// Підключення до бази даних
$servername = "localhost";
$username = "root";  // замініть на вашого користувача
$password = "";      // замініть на ваш пароль
$dbname = "EmployeeManagement";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Помилка підключення: " . $e->getMessage());
}

// Обробка форми додавання працівника
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $salary = (float)$_POST['salary'];
    
    if (!empty($name) && !empty($position) && $salary > 0) {
        try {
            $stmt = $conn->prepare("INSERT INTO Employees (name, position, salary) VALUES (?, ?, ?)");
            $stmt->execute([$name, $position, $salary]);
            $success_message = "Працівника успішно додано!";
        } catch(PDOException $e) {
            $error_message = "Помилка при додаванні: " . $e->getMessage();
        }
    } else {
        $error_message = "Будь ласка, заповніть всі поля коректно!";
    }
}

// Обробка форми редагування працівника
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_employee'])) {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $salary = (float)$_POST['salary'];
    
    if ($id > 0 && !empty($name) && !empty($position) && $salary > 0) {
        try {
            $stmt = $conn->prepare("UPDATE Employees SET name = ?, position = ?, salary = ? WHERE id = ?");
            $stmt->execute([$name, $position, $salary, $id]);
            $success_message = "Дані працівника успішно оновлено!";
        } catch(PDOException $e) {
            $error_message = "Помилка при оновленні: " . $e->getMessage();
        }
    } else {
        $error_message = "Будь ласка, заповніть всі поля коректно!";
    }
}

// Отримання даних працівника для редагування
$edit_employee = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT * FROM Employees WHERE id = ?");
        $stmt->execute([$id]);
        $edit_employee = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Пошук працівників
$search = $_GET['search'] ?? '';
$where = '';
$params = [];

if (!empty($search)) {
    $where = "WHERE name LIKE ? OR position LIKE ?";
    $params = ["%$search%", "%$search%"];
}

// Отримання списку працівників
$stmt = $conn->prepare("SELECT * FROM Employees $where ORDER BY name");
$stmt->execute($params);
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управління працівниками</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 100px; }
        input, select { padding: 8px; width: 300px; }
        button { padding: 10px 15px; cursor: pointer; }
        .btn-add { background: #4CAF50; color: white; border: none; }
        .btn-edit { background: #2196F3; color: white; border: none; }
        .btn-cancel { background: #f44336; color: white; border: none; }
        button:hover { opacity: 0.8; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .search-box { margin: 20px 0; }
        .search-box input { width: 400px; padding: 10px; }
        .search-box button { padding: 10px 20px; }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background-color: #dff0d8; color: #3c763d; }
        .error { background-color: #f2dede; color: #a94442; }
        .actions { white-space: nowrap; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Система управління працівниками</h1>
        
        <!-- Форма додавання/редагування працівника -->
        <h2><?= $edit_employee ? 'Редагувати працівника' : 'Додати нового працівника' ?></h2>
        <?php if (isset($success_message)): ?>
            <div class="message success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="message error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <?php if ($edit_employee): ?>
                <input type="hidden" name="id" value="<?= $edit_employee['id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="name">Ім'я:</label>
                <input type="text" id="name" name="name" required 
                       value="<?= $edit_employee ? htmlspecialchars($edit_employee['name']) : '' ?>">
            </div>
            <div class="form-group">
                <label for="position">Посада:</label>
                <input type="text" id="position" name="position" required
                       value="<?= $edit_employee ? htmlspecialchars($edit_employee['position']) : '' ?>">
            </div>
            <div class="form-group">
                <label for="salary">Зарплата:</label>
                <input type="number" id="salary" name="salary" step="0.01" min="0" required
                       value="<?= $edit_employee ? htmlspecialchars($edit_employee['salary']) : '' ?>">
            </div>
            <?php if ($edit_employee): ?>
                <button type="submit" name="edit_employee" class="btn-edit">Оновити дані</button>
                <a href="?" class="btn-cancel" style="padding: 10px 15px; text-decoration: none;">Скасувати</a>
            <?php else: ?>
                <button type="submit" name="add_employee" class="btn-add">Додати працівника</button>
            <?php endif; ?>
        </form>
        
        <!-- Пошук працівників -->
        <div class="search-box">
            <h2>Пошук працівників</h2>
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Введіть ім'я або посаду..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Шукати</button>
                <?php if (!empty($search)): ?>
                    <a href="?" style="margin-left: 10px;">Скинути пошук</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Список працівників -->
        <h2>Список працівників</h2>
        <?php if (count($employees) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ім'я</th>
                        <th>Посада</th>
                        <th>Зарплата</th>
                        <th class="actions">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?= htmlspecialchars($employee['id']) ?></td>
                            <td><?= htmlspecialchars($employee['name']) ?></td>
                            <td><?= htmlspecialchars($employee['position']) ?></td>
                            <td><?= number_format($employee['salary'], 2, '.', ' ') ?> ₴</td>
                            <td class="actions">
                                <a href="?edit=<?= $employee['id'] ?>" class="btn-edit" style="padding: 5px 10px; text-decoration: none;">Редагувати</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Всього працівників: <?= count($employees) ?></p>
        <?php else: ?>
            <p>Працівників не знайдено.</p>
        <?php endif; ?>
    </div>
</body>
</html>