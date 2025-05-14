<body>
<?php
$link = mysqli_connect("localhost", "admin", "admin");

if($link) {
  echo "З'єднання встановлене <br>";
} else {
  die("З'єднання не створене");
}

$db = "GalleryDB";

$querry = "CREATE DATABASE IF NOT EXISTS $db";

$create_db = mysqli_query($link, $querry);

if($create_db){
  echo "База даних створена <br>";
} else{
  echo "База не створена <br>";
}
?>
</body>