<?php

class Monedas{

  public function insertMoneda($nombre){
    
    $consulta = conectarDB("INSERT INTO `monedas`
    (`nombre`,`estado`)
    VALUES
    ('$nombre','1')
    ");
  }
  public function returnMoneda(int $id){
      $consulta = conectarDB(" SELECT * FROM `monedas` WHERE `idMoneda`='$id' ");
      $mon = new Moneda;
      $c = mysqli_fetch_assoc($consulta);
      $mon->idSucursal = $c['idMoneda'];
      $mon->nombre = $c['nombre'];
      $mon->estado = $c['estado'];
      return $mon;  
  }
  public function returnMonedas(){
    $consulta = conectarDB(" SELECT * FROM `monedas`");
    $mons = [];
    foreach($consulta as $c){
      $mon = new Moneda;
      
      $mon->idSucursal = $c['idMoneda'];
      $mon->nombre = $c['nombre'];
      $mon->estado = $c['estado'];

      $mons[] = $suc;
    }
    return $mons;  
  }
  public function updateMoneda($nombre, $id){
    
    $consulta = conectarDB("UPDATE `monedas` SET
    `nombre`='$nombre' WHERE `idMoneda` = '$id' ");
  }
  public function deleteMoneda(int $id){
    
    $consulta = conectarDB("UPDATE `monedas` SET
    `estado`='0'
    WHERE `idMoneda` = '$id' 
    ");
  }
  public function restartSucursal(int $id){
    
    $consulta = conectarDB("UPDATE `monedas` SET
    `estado`='1'
    WHERE `idMoneda` = '$id' 
    ");
  }
}