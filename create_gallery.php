<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "GalleryDB";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author = $_POST['author'];
    $filename = $_POST['filename'];

    $sql = "INSERT INTO gallery (author, filename) VALUES ('$author', '$filename')";

    if (mysqli_query($connection, $sql)) {
        echo "Запис успішно додано!";
    } else {
        echo "Помилка при додаванні запису: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати запис до галереї</title>
</head>
<body>
    <h2>Додати новий запис до галереї</h2>
    <form action="create_gallery.php" method="POST">
        <label for="author">Автор:</label>
        <input type="text" id="author" name="author" required /><br><br>
        
        <label for="filename">Назва файлу:</label>
        <input type="text" id="filename" name="filename" required /><br><br>

        <input type="submit" value="Додати запис">
    </form>

    <br>
    <a href="gallery.php"><button>Перейти до списку записів</button></a>
</body>
</html>

<?php
mysqli_close($connection);
?>
