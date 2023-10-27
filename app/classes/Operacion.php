<?php 
class Operacion{
  public $idOperacion;
  public $idUsuario;
  public $fecha;
  public $hora;
  public $tipoOperacion;
  public $detalle;
  public $idMoneda;
  public $monto;
  public $cotizacion;
  public $estado;

  function __construct(){
    $this->detalle = "";
  }
};