<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "GalleryDB";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

// 1. Загальна кількість записів у таблицях
$total_gallery_query = "SELECT COUNT(*) AS total FROM gallery";
$total_files_query = "SELECT COUNT(*) AS total FROM files";

$total_gallery_result = mysqli_query($connection, $total_gallery_query);
$total_files_result = mysqli_query($connection, $total_files_query);

$total_gallery = mysqli_fetch_assoc($total_gallery_result)['total'];
$total_files = mysqli_fetch_assoc($total_files_result)['total'];

// 2. Кількість записів за останній місяць
$last_month = date('Y-m-d H:i:s', strtotime('-1 month'));
$recent_gallery_query = "SELECT COUNT(*) AS total FROM gallery WHERE created >= '$last_month'";
$recent_files_query = "SELECT COUNT(*) AS total FROM files WHERE created >= '$last_month'";

$recent_gallery_result = mysqli_query($connection, $recent_gallery_query);
$recent_files_result = mysqli_query($connection, $recent_files_query);

$recent_gallery = mysqli_fetch_assoc($recent_gallery_result)['total'];
$recent_files = mysqli_fetch_assoc($recent_files_result)['total'];

// 3. Останній запис у таблиці gallery
$last_gallery_query = "SELECT filename FROM gallery ORDER BY created DESC LIMIT 1";
$last_gallery_result = mysqli_query($connection, $last_gallery_query);
$last_gallery = mysqli_fetch_assoc($last_gallery_result)['filename'] ?? 'Немає записів';

// 4. Запис із найбільшою кількістю пов’язаних файлів
$most_related_query = "
    SELECT g.filename, COUNT(f.id) AS files_count
    FROM gallery g
    LEFT JOIN files f ON f.flie_id = g.id
    GROUP BY g.id
    ORDER BY files_count DESC
    LIMIT 1";

$most_related_result = mysqli_query($connection, $most_related_query);
$most_related = mysqli_fetch_assoc($most_related_result);
$most_related_filename = $most_related['filename'] ?? 'Немає записів';
$most_related_count = $most_related['files_count'] ?? 0;

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Статистика галереї</title>
</head>
<body>
    <h2>Статистика галереї</h2>
    <p>Загальна кількість записів у таблиці gallery: <?= $total_gallery ?></p>
    <p>Загальна кількість записів у таблиці files: <?= $total_files ?></p>
    <p>Кількість записів у таблиці gallery за останній місяць: <?= $recent_gallery ?></p>
    <p>Кількість записів у таблиці files за останній місяць: <?= $recent_files ?></p>
    <p>Останній доданий запис у таблиці gallery: <?= $last_gallery ?></p>
    <p>Запис із найбільшою кількістю пов’язаних файлів: <?= $most_related_filename ?> (<?= $most_related_count ?> файлів)</p>

    <br>
    <a href="gallery.php"><button>Повернутися до галереї</button></a>
</body>
</html>