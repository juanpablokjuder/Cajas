<?php

$pathInicio="/Cajas/";

require "functions/funciones.php";
require "classes/_Classes.php";
require "controllers/_Controllers.php";

###VALIDAR USUARIO
session_start();
  if(!isset($_SESSION['rol'])){
    if($_SERVER["REQUEST_URI"] != $GLOBALS['pathInicio']."iniciarSesion.php"){
      header("location: iniciarSesion.php");
      die;
    }
  
      
  }

?>