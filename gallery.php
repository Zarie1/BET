<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "GalleryDB";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

// Фільтрація
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Сортування
$sortable_columns = ['id', 'author', 'filename', 'created'];
$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $sortable_columns) ? $_GET['sort_by'] : 'id';
$order = (isset($_GET['order']) && $_GET['order'] == 'desc') ? 'DESC' : 'ASC';
$next_order = $order === 'ASC' ? 'desc' : 'asc';

// Побудова запиту
$query = "SELECT * FROM gallery WHERE 1=1";

if (!empty($search)) {
    $query .= " AND (author LIKE '%$search%' OR filename LIKE '%$search%')";
}

if (!empty($start_date)) {
    $query .= " AND created >= '$start_date'";
}

if (!empty($end_date)) {
    $query .= " AND created <= '$end_date'";
}

$query .= " ORDER BY $sort_by $order";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Галерея</title>
</head>
<body>
    <h2>Список зображень</h2>

    <form method="GET" action="">
        <input type="text" name="search" placeholder="Пошук за автором або назвою..." value="<?= htmlspecialchars($search) ?>">
        <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
        <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
        <button type="submit">Пошук</button>
    </form>
    <br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th><a href="?sort_by=id&order=<?= $next_order ?>">ID</a></th>
                <th><a href="?sort_by=author&order=<?= $next_order ?>">Автор</a></th>
                <th><a href="?sort_by=filename&order=<?= $next_order ?>">Назва файлу</a></th>
                <th><a href="?sort_by=created&order=<?= $next_order ?>">Дата створення</a></th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['author']; ?></td>
                        <td><a href="ref.php?id=<?= $row['id']; ?>"><?= $row['filename']; ?></a></td>
                        <td><?= $row['created']; ?></td>
                        <td>
                            <a href="edit_gallery.php?id=<?= $row['id']; ?>">Редагувати</a> |
                            <a href="delete_gallery.php?id=<?= $row['id']; ?>">Видалити</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Немає записів для відображення.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="create_gallery.php"><button>Додати новий запис</button></a>
    <a href="info.php"><button>Переглянути статистику</button></a>
</body>
</html>

<?php
mysqli_close($connection);
?>