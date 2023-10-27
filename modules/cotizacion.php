<?php
require "./../app/app.php";

$moneda = $_GET['moneda'];
$operacion = $_GET['operacion'];

$cotizacion = new Cotizaciones;
$cotizacion = $cotizacion->returnUltimaCotizacionMoneda($moneda);

if($moneda == 2){
  //dolar
  if($operacion == 1){
    //compra
    // $consulta = conectarDB("SELECT MAX(`idCotizacion`),`compra` FROM `cotizaciones` WHERE `idMoneda`= 2 AND `estado` = 1");
    // $c = mysqli_fetch_assoc($consulta);
    echo $cotizacion->compra;
  }
  if($operacion == 2){
    //venta
    // $consulta = conectarDB("SELECT MAX(`idCotizacion`),`venta` FROM `cotizaciones` WHERE `idMoneda`= 2 AND `estado` = 1");
    // $c = mysqli_fetch_assoc($consulta);
    echo $cotizacion->venta;
  }
}

if($moneda == 3){
  //euro
  if($operacion == 1){
    //compra
    // $consulta = conectarDB("SELECT MAX(`idCotizacion`),`compra` FROM `cotizaciones` WHERE `idMoneda`= 3 AND `estado` = 1");
    // $c = mysqli_fetch_assoc($consulta);
    echo $cotizacion->compra;

  }
  if($operacion == 2){
    //venta
    // $consulta = conectarDB("SELECT MAX(`idCotizacion`),`venta` FROM `cotizaciones` WHERE `idMoneda`= 3 AND `estado` = 1");
    // $c = mysqli_fetch_assoc($consulta);
    echo $cotizacion->venta;
  }
}
