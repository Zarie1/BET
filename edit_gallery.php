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

if (isset($_GET['id'])) {
    $gallery_id = $_GET['id'];

    $gallery_query = "SELECT * FROM gallery WHERE id = $gallery_id";
    $gallery_result = mysqli_query($connection, $gallery_query);

    if (mysqli_num_rows($gallery_result) > 0) {
        $gallery = mysqli_fetch_assoc($gallery_result);
    } else {
        echo "Запис не знайдено.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author = $_POST['author'];
    $filename = $_POST['filename'];

    $sql = "UPDATE gallery SET author = '$author', filename = '$filename' WHERE id = $gallery_id";

    if (mysqli_query($connection, $sql)) {
        echo "Запис успішно оновлено!";
    } else {
        echo "Помилка при оновленні запису: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати запис</title>
</head>
<body>
    <h2>Редагувати запис</h2>
    <form action="edit_gallery.php?id=<?= $gallery_id; ?>" method="POST">
        <label for="author">Автор:</label>
        <input type="text" id="author" name="author" value="<?= $gallery['author']; ?>" required /><br><br>
        
        <label for="filename">Назва файлу:</label>
        <input type="text" id="filename" name="filename" value="<?= $gallery['filename']; ?>" required /><br><br>

        <input type="submit" value="Оновити запис">
    </form>

    <br>
    <a href="gallery.php"><button>Перейти до списку записів</button></a>
</body>
</html>

<?php
mysqli_close($connection);
?>