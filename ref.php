<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "GalleryDB";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

$gallery_id = $_GET['id'];

$sql = "SELECT id, flie_id, size, created FROM files WHERE flie_id = $gallery_id";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Файли, пов’язані з записом #$gallery_id</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>file_id</th>
                <th>size</th>
                <th>created</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['flie_id']}</td>
                <td>{$row['size']}</td>
                <td>{$row['created']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Немає файлів, пов’язаних із записом ID = $gallery_id";
}

mysqli_close($connection);
?>