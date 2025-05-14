<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "GalleryDB";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

$sql = "SELECT id, author, filename FROM gallery";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Автор</th>
                <th>Файл</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['author']}</td>
                <td><a href='ref.php?id={$row['id']}'>{$row['filename']}</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Немає записів для відображення.";
}

mysqli_close($connection);
?>