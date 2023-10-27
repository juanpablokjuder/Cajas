<?php
class Cotizaciones{
  public function insertCotizacion(Cotizacion $cot){
    
    $consulta = conectarDB("INSERT INTO `cotizaciones`
    (`idMoneda`, `idUsuario`, `compra`, `venta`, `fecha`, `hora`, `estado`)
     VALUES ('$cot->idMoneda','$cot->idUsuario','$cot->compra',
     '$cot->venta',CURDATE(),CURTIME(),1)
    ");
  }
  public function returnCotizacion(int $id){
    $consulta = conectarDB(" SELECT * FROM `cotizaciones` WHERE `idCotizacion`='$id' ");
    $cot = new Cotizacion;
    $c = mysqli_fetch_assoc($consulta);
    $cot->idCotizacion = $c['idCotizacion'];
    $cot->idMoneda = $c['idMoneda'];
    $cot->idUsuario = $c['idUsuario'];
    $cot->compra = $c['compra'];
    $cot->venta = $c['venta'];
    $cot->fecha = $c['fecha'];
    $cot->hora = $c['hora'];
    $cot->estado = $c['estado'];
    return $cot;  
  }
  public function returnUltimaCotizacionMoneda(int $idMoneda){
    $consulta = conectarDB(" SELECT * FROM `cotizaciones` WHERE `idMoneda`='$idMoneda' 
    ORDER BY `idCotizacion` DESC
    LIMIT 1
    OFFSET 0
    ");
    $cot = new Cotizacion;
    $c = mysqli_fetch_assoc($consulta);
    $cot->idCotizacion = $c['idCotizacion'];
    $cot->idMoneda = $c['idMoneda'];
    $cot->idUsuario = $c['idUsuario'];
    $cot->compra = $c['compra'];
    $cot->venta = $c['venta'];
    $cot->fecha = $c['fecha'];
    $cot->hora = $c['hora'];
    $cot->estado = $c['estado'];
    return $cot;  
  }
  public function returnCotizaciones(){
    $consulta = conectarDB(" SELECT * FROM `cotizaciones`");
    $cots = [];
    foreach($consulta as $c){
      $cot = new Cotizacion;

      $cot->idCotizacion = $c['idCotizacion'];
      $cot->idMoneda = $c['idMoneda'];
      $cot->idUsuario = $c['idUsuario'];
      $cot->compra = $c['compra'];
      $cot->venta = $c['venta'];
      $cot->fecha = $c['fecha'];
      $cot->hora = $c['hora'];
      $cot->estado = $c['estado'];

      $cots[] = $cot;
    }
    return $cots;  
  }
  public function updateCotizacion(Cotizacion $cot){
    
    $consulta = conectarDB("UPDATE `cotizaciones` SET
    `idMoneda`='$cot->idMoneda',
    `idUsuario`='$cot->idUsuario',
    `compra`='$cot->compra',
    `venta`='$cot->venta',
    `fecha`='$cot->fecha',
    `hora`='$cot->hora',
    `estado`='$cot->estado'
    WHERE `idCotizacion`='$cot->idCotizacion'");
  }
  public function deleteCotizacion(int $id){
    
    $consulta = conectarDB("UPDATE `cotizaciones` SET
    `estado`='0'
    WHERE `idCotizacion` = '$id' 
    ");
  }
  public function restartSucursal(int $id){
    
    $consulta = conectarDB("UPDATE `cotizaciones` SET
    `estado`='1'
    WHERE `idCotizaciones` = '$id' 
    ");
  }
}