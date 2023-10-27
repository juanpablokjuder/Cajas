<?php
require "./../app/app.php";
$cons = conectarDB("SELECT * FROM `token` ");
$c = mysqli_fetch_assoc($cons);

echo $c['token'];