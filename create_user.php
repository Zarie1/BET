<body>
<?php
$link = mysqli_connect("localhost", "admin", "admin");

if($link) {
  echo "З'єднання встановлене <br>";
} else {
  die("З'єднання не створене");
}

$querry = "GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'admin' WITH GRANT OPTION";


$create_user = mysqli_query($link, $querry);

if($create_user){
  echo "Права користувача надані! <br>";
} else{
  echo "Не вдалося надати привілеї! <br>";
}
?>
</body>