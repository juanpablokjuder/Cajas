<?php
  require "./../app/app.php";
  $token = token();
  conectarDB("UPDATE `token` SET `token`='$token', `fecha_hora` = NOW() ");


