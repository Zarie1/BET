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

// Обробка параметрів сортування
$sortable_columns = ['id', 'author', 'filename'];
$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $sortable_columns) ? $_GET['sort_by'] : 'id';
$order = (isset($_GET['order']) && $_GET['order'] == 'desc') ? 'DESC' : 'ASC';
$next_order = $order === 'ASC' ? 'desc' : 'asc';

$query = "SELECT * FROM gallery ORDER BY $sort_by $order";
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

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th><a href="?sort_by=id&order=<?= $next_order ?>">ID</a></th>
                <th><a href="?sort_by=author&order=<?= $next_order ?>">Автор</a></th>
                <th><a href="?sort_by=filename&order=<?= $next_order ?>">Назва файлу</a></th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['author']; ?></td>
                    <td><?= $row['filename']; ?></td>
                    <td>
                        <a href="edit_gallery.php?id=<?= $row['id']; ?>">Редагувати</a> |
                        <a href="delete_gallery.php?id=<?= $row['id']; ?>">Видалити</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>
    <a href="create_gallery.php"><button>Додати новий запис</button></a>
</body>
</html>

<?php
mysqli_close($connection);
?>