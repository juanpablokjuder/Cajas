<?php
require "./../app/app.php";

$saldo = 0;
if($_GET['moneda'] == "1"){
  //pesos
  //todas las compras ventas ingresos egresos y personalizados
  $compras = conectarDB("SELECT SUM(`monto`*`cotizacion`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 1 AND `Estado` = 1 ");
  $compra = mysqli_fetch_assoc($compras);
  $saldo -= $compra['saldo'];
  
  $ventas = conectarDB("SELECT SUM(`monto`*`cotizacion`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 2 AND `Estado` = 1 ");
  $venta = mysqli_fetch_assoc($ventas);
  $saldo += $venta['saldo'];

  $ingresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 3 AND `Estado` = 1 AND `idMoneda` = 1");
  $ingreso = mysqli_fetch_assoc($ingresos);
  $saldo += $ingreso['saldo'];
  
  $egresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 4 AND `Estado` = 1 AND `idMoneda` = 1");
  $egreso = mysqli_fetch_assoc($egresos);
  $saldo += $egreso['saldo'];

  $personalizados = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 5 AND `Estado` = 1 AND `idMoneda` = 1");
  $personalizado = mysqli_fetch_assoc($personalizados);
  $saldo += $personalizado['saldo'];


   echo "$".number_format($saldo, 2, ',', '.');
}
if($_GET['moneda'] == "2"){
  //dolares
    //todas las compras ventas ingresos egresos y personalizados
    $compras = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 1 AND `Estado` = 1 AND `idMoneda` = 2");
    $compra = mysqli_fetch_assoc($compras);
    $saldo += $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 2 AND `Estado` = 1 AND `idMoneda` = 2");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo -= $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 3 AND `Estado` = 1 AND `idMoneda` = 2");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 4 AND `Estado` = 1 AND `idMoneda` = 2");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 5 AND `Estado` = 1 AND `idMoneda` = 2");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];
  
  
     echo '$'.number_format($saldo, 2, ',', '.');
  // echo "2";
}
if($_GET['moneda'] == "3"){
  //euros
  $compras = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 1 AND `Estado` = 1 AND `idMoneda` = 3");
  $compra = mysqli_fetch_assoc($compras);
  $saldo += $compra['saldo'];
  
  $ventas = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 2 AND `Estado` = 1 AND `idMoneda` = 3");
  $venta = mysqli_fetch_assoc($ventas);
  $saldo -= $venta['saldo'];

  $ingresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 3 AND `Estado` = 1 AND `idMoneda` = 3");
  $ingreso = mysqli_fetch_assoc($ingresos);
  $saldo += $ingreso['saldo'];
  
  $egresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 4 AND `Estado` = 1 AND `idMoneda` = 3");
  $egreso = mysqli_fetch_assoc($egresos);
  $saldo += $egreso['saldo'];

  $personalizados = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 5 AND `Estado` = 1 AND `idMoneda` = 3");
  $personalizado = mysqli_fetch_assoc($personalizados);
  $saldo += $personalizado['saldo'];


   echo "€".number_format($saldo, 2, ',', '.');
  // echo "3";
}