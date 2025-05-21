<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "GalleryDB";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $gallery_id = (int)$_GET['id'];

    $gallery_query = "SELECT * FROM gallery WHERE id = $gallery_id";
    $gallery_result = mysqli_query($connection, $gallery_query);

    if (mysqli_num_rows($gallery_result) > 0) {
        $gallery = mysqli_fetch_assoc($gallery_result);
    } else {
        echo "Запис не знайдено.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // First delete related files from the files table
        $delete_files_sql = "DELETE FROM files WHERE flie_id = $gallery_id";
        mysqli_query($connection, $delete_files_sql);
        
        // Then delete the gallery entry
        $sql = "DELETE FROM gallery WHERE id = $gallery_id";

        if (mysqli_query($connection, $sql)) {
            echo "Запис успішно видалено!";
            header("Location: gallery.php");
            exit();
        } else {
            echo "Помилка при видаленні запису: " . mysqli_error($connection);
        }
    }
} else {
    echo "Не вказано ID запису для видалення.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видалити запис</title>
</head>
<body>
    <h2>Видалити запис</h2>
    <p>Ви дійсно хочете видалити запис #<?= $gallery_id ?> (<?= $gallery['filename'] ?>)?</p>
    <form action="delete_gallery.php?id=<?= $gallery_id ?>" method="POST">
        <input type="submit" value="Видалити запис">
    </form>
    <br>
    <a href="gallery.php"><button>Перейти до списку записів</button></a>
</body>
</html>

<?php
mysqli_close($connection);
?>