<?php

class Sucursales{
  public function insertSucursal($nombre){
    
    $consulta = conectarDB("INSERT INTO `sucursales` (`nombre`,`estado`)
    VALUES ('$nombre','1') ");
    
  }
  public function returnSucursal(int $id){
      $consulta = conectarDB(" SELECT * FROM `sucursales` WHERE `idSucursal`='$id' ");
      $suc = new Sucursal;
      $c = mysqli_fetch_assoc($consulta);
      $suc->idSucursal = $c['idSucursal'];
      $suc->nombre = $c['nombre'];
      $suc->estado = $c['estado'];
      return $suc;  
  }
  public function returnSucursales(){
    $consulta = conectarDB(" SELECT * FROM `sucursales`");
    $sucs = [];
    foreach($consulta as $c){
      $suc = new Sucursal;
      
      $suc->idSucursal = $c['idSucursal'];
      $suc->nombre = $c['nombre'];
      $suc->estado = $c['estado'];

      $sucs[] = $suc;
    }
    return $sucs;  
  }
  public function updateSucursal($nombre, $id){
    
    $consulta = conectarDB("UPDATE `sucursales` SET
    `nombre`='$nombre' WHERE `idSucursal` = '$id' ");
  }
  public function deleteSucursal(int $id){
    
    $consulta = conectarDB("UPDATE `sucursales` SET
    `estado`='0'
    WHERE `idSucursal` = '$id' 
    ");
  }
  public function restartSucursal(int $id){
    
    $consulta = conectarDB("UPDATE `sucursales` SET
    `estado`='1'
    WHERE `idSucursal` = '$id' 
    ");
  }
}