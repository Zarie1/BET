<body>
<?php
$link = mysqli_connect("localhost", "admin", "admin");

$db = "GalleryDB";
$select = mysqli_select_db($link, $db);

if ($select) {
  echo "БД вибрана <br>";
} else {
  die("БД не вибрана <br>");
}

$querry = "CREATE TABLE IF NOT EXISTS gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  author VARCHAR(100) NOT NULL,
  filename VARCHAR(255) NOT NULL UNIQUE
)";

$create_table = mysqli_query($link, $querry);

if($create_table){
  echo "Таблиця створена! <br>";
} else{
  echo "Таблиця не створена! <br>";
}
?>
</body>