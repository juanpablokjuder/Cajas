<?php
// require "app/app.php";
require "./../app/app.php";
generarToken();


$cons = conectarDB("SELECT * FROM `token` ");
$c = mysqli_fetch_assoc($cons);

$co = conectarDB("SELECT TIMESTAMPDIFF(SECOND, `fecha_hora`, NOW()) as 'hora' FROM `token`");
$time = mysqli_fetch_assoc($co);

?>
<div class="contToken">
  <div>
    <h1><?php echo sprintf('%02d', 30-$time['hora']) ?></h1>
    <h2><?php echo $c['token']?></h2>
  </div>
</div>