<?php 
class Operaciones{
  public function returnSaldoPesosUsuario($id){
    $saldo = 0;
    //pesos
    //todas las compras ventas ingresos egresos y personalizados
    $compras = conectarDB("SELECT SUM(`monto`*`cotizacion`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 1 AND `Estado` = 1 AND `idUsuario`=$id");
    $compra = mysqli_fetch_assoc($compras);
    $saldo -= $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(`monto`*`cotizacion`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 2 AND `Estado` = 1 AND `idUsuario`=$id");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo += $venta['saldo'];

    $ingresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 3 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 1");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 4 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 1");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];

    $personalizados = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 5 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 1");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];

    return $saldo;
  }
  public function returnSaldoDolaresUsuario($id){
    $saldo = 0;
    //dolares
    //todas las compras ventas ingresos egresos y personalizados
    $compras = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 1 AND `Estado` = 1 AND `idUsuario`=$id AND `idMoneda` = 2");
    $compra = mysqli_fetch_assoc($compras);
    $saldo += $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 2 AND `Estado` = 1 AND `idUsuario`=$id AND `idMoneda` = 2");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo -= $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 3 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 2");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 4 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 2");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 5 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 2");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];

    return $saldo;
  }
  public function returnSaldoEurosUsuario($id){
    $saldo = 0;
    //euros
    $compras = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 1 AND `Estado` = 1 AND `idUsuario`=$id AND `idMoneda` = 3");
    $compra = mysqli_fetch_assoc($compras);
    $saldo += $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 2 AND `Estado` = 1 AND `idUsuario`=$id AND `idMoneda` = 3");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo -= $venta['saldo'];

    $ingresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 3 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 3");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 4 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 3");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];

    $personalizados = conectarDB("SELECT SUM(`monto`) as 'saldo' FROM `operaciones` WHERE `tipoOperacion` = 5 AND `Estado` = 1 AND `idUsuario` = $id AND `idMoneda` = 3");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];

    return $saldo;
  }
  public function insertOperacion(Operacion $op){
    
    if($op->monto==0 || $op->monto==""){
      error("FALTA CANTIDAD");
      return;
    }
    if($op->tipoOperacion < 1 || $op->tipoOperacion > 5){
      error("ERROR EN OPERACION");
      return;
    }
    if($op->idMoneda == "" || $op->idMoneda < 1 || $op->idMoneda > 3){
      error("ERROR EN MONEDA");
      return;
    }
    if($op->tipoOperacion == 1 || $op->tipoOperacion == 2){
      if($op->cotizacion == null || $op->cotizacion == "" || $op->cotizacion == 0){
        error("FALTA COTIZACION");
        return;
      }
      if($op->monto==0){
        error("EL MONTO NO PUEDE SER 0");
        return;
      }
      if($op->monto<0){
        error("EL MONTO NO PUEDE SER MENOR A 0");
        return;
      }
    }
    if($op->tipoOperacion == 5){
      if($op->detalle == null || $op->detalle == ""){
        error("FALTA DETALLE");
        return;
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    // VALIDACION DE SALDOS
    if($op->tipoOperacion==1){
      //compras
      if($this->returnSaldoPesosUsuario($op->idUsuario) - $op->monto*$op->cotizacion < 0){
        error("SALDO PESOS INSUFICIENTE");
        return;
      }
    }
    if($op->tipoOperacion==2){
      if($op->idMoneda == 2){
        if($this->returnSaldoDolaresUsuario($op->idUsuario) - $op->monto <0){
          error("SALDO DOLARES INSUFICIENTE");
          return;
        }
      }
      if($op->idMoneda == 3){
        if($this->returnSaldoEurosUsuario($op->idUsuario) - $op->monto <0){
          error("SALDO EUROS INSUFICIENTE");
          return;
        }
      }

    }
    if($op->tipoOperacion==4){
      if($op->idMoneda == 1){
        if($this->returnSaldoPesosUsuario($op->idUsuario) + $op->monto <0){
          error("SALDO PESOS INSUFICIENTE");
          return;
        }
      }
      if($op->idMoneda == 2){
        if($this->returnSaldoDolaresUsuario($op->idUsuario) + $op->monto <0){
          error("SALDO DOLARES INSUFICIENTE");
          return;
        }
      }
      if($op->idMoneda == 3){
        if($this->returnSaldoEurosUsuario($op->idUsuario) + $op->monto <0){
          error("SALDO EUROS INSUFICIENTE");
          return;
        }
      }

    }
    ////////////////////////////////////////////////////////////////////////////
    $fecha_actual = new DateTime();
    $consulta = conectarDB("INSERT INTO `operaciones`
    (`idUsuario`, `fecha`, `hora`, `tipoOperacion`,
    `idMoneda`,`monto`, `cotizacion`, `estado`) VALUES
    ('$op->idUsuario',CURDATE(),CURTIME(),'$op->tipoOperacion',
    '$op->idMoneda','$op->monto','$op->cotizacion','1')
    ");
    if($op->detalle != null || $op->detalle != ""){
      $ultimaID = mysqli_fetch_assoc(conectarDB("SELECT AUTO_INCREMENT
      FROM information_schema.TABLES
      WHERE TABLE_SCHEMA = 'cajas'
        AND TABLE_NAME = 'operaciones'"))["AUTO_INCREMENT"] - 1;
      
      conectarDB("INSERT INTO `detalles` (`idOperacion`, `detalle`)
       VALUES ('$ultimaID', '$op->detalle')");
    }
    if($op->tipoOperacion == 1 || $op->tipoOperacion == 2){
    ////
    //   IMPRIMIR TICKET TICKET
        $fecha = $fecha_actual->format('d/m/Y');
        $hora = $fecha_actual->format('H:i:s');
        $operacion = $op->tipoOperacion == 1 ? "compra" :  "venta";
        $moneda = $op->idMoneda == 2 ? "USD" : "EUR";
        $monto = $op->monto;
        $cot = $op->cotizacion;
        $total = $op->cotizacion * $op->monto;
        ImprimirTicket($fecha,$hora,$operacion,$moneda,$monto,$cot,$total);        
    ////
    }
    return true;
  }
  public function returnOperacion(int $id){
      $consulta = conectarDB(" SELECT * FROM `operaciones` WHERE `idOperacion`='$id' ");
      $op = new Operacion;
      $c = mysqli_fetch_assoc($consulta);
      $op->idOperacion = $c['idOperacion'];
      $op->idUsuario = $c['idUsuario'];
      $op->fecha = $c['fecha'];
      $op->hora = $c['hora'];
      $op->tipoOperacion = $c['tipoOperacion'];
      $op->idMoneda = $c['idMoneda'];
      $op->monto = $c['monto'];
      $op->cotizacion = $c['cotizacion'];
      $op->estado = $c['estado'];
      
      switch ($op->tipoOperacion) {
        case 1: $op->detalle = "Compra";
          break;
        case 2: $op->detalle = "Venta";
          break;
        case 3: $op->detalle = "Ingreso";
          break;
        case 4: $op->detalle = "Egreso";
          break;
        case 5:
          $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$id' ");
          if($consulta2->num_rows>0){
            $c2 = mysqli_fetch_assoc($consulta2);
            $op->detalle = $c2['detalle'];
          }
          break;
        default: $op->detalle = "";
          break;
      }


      return $op;  
  }
  public function returnOperaciones(){
    $consulta = conectarDB(" SELECT * FROM `operaciones`");
    $ops = [];
    foreach($consulta as $c){
      $op = new Operacion;
      $op->idOperacion = $c['idOperacion'];
      $op->idUsuario = $c['idUsuario'];
      $op->fecha = $c['fecha'];
      $op->hora = $c['hora'];
      $op->tipoOperacion = $c['tipoOperacion'];
      $op->idMoneda = $c['idMoneda'];
      $op->monto = $c['monto'];
      $op->cotizacion = $c['cotizacion'];
      $op->estado = $c['estado'];
      switch ($op->tipoOperacion) {
        case 1: $op->detalle = "Compra";
          break;
        case 2: $op->detalle = "Venta";
          break;
        case 3: $op->detalle = "Ingreso";
          break;
        case 4: $op->detalle = "Egreso";
          break;
        case 5:
          $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
          if($consulta2->num_rows>0){
            $c2 = mysqli_fetch_assoc($consulta2);
            $op->detalle = $c2['detalle'];
          }
          break;
        default: $op->detalle = "";
          break;
      }

      $ops[] = $op;
    }
    return $ops;  
  }
  public function returnOperacionesUsuario($idUsuario, $fecha){
    $consulta = conectarDB(" SELECT * FROM `operaciones` 
    WHERE `idUsuario`='$idUsuario' AND `fecha`='$fecha' 
    ORDER BY `idOperacion` DESC
    LIMIT 100
    OFFSET 0
    ");
    $ops = [];
    $cont = 0;
    foreach($consulta as $c){
     
      $op = new Operacion;
      $op->idOperacion = $c['idOperacion'];
      $op->idUsuario = $c['idUsuario'];
      $op->fecha = $c['fecha'];
      $op->hora = $c['hora'];
      $op->tipoOperacion = $c['tipoOperacion'];
      $op->idMoneda = $c['idMoneda'];
      $op->monto = $c['monto'];
      $op->cotizacion = $c['cotizacion'];
      $op->estado = $c['estado'];
      switch ($op->tipoOperacion) {
        case 1: $op->detalle = "Compra";
          break;
        case 2: $op->detalle = "Venta";
          break;
        case 3:          $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
        if($consulta2->num_rows>0){
          $c2 = mysqli_fetch_assoc($consulta2);
          $op->detalle = $c2['detalle'];
        }
        break;
        case 4:           $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
        if($consulta2->num_rows>0){
          $c2 = mysqli_fetch_assoc($consulta2);
          $op->detalle = $c2['detalle'];
        }
        break;
        case 5:
          $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
          if($consulta2->num_rows>0){
            $c2 = mysqli_fetch_assoc($consulta2);
            $op->detalle = $c2['detalle'];
          }
          break;
        default: $op->detalle = "";
          break;
          
      }
      
      $ops[] = $op;
    }
    
    return $ops;  
  }
  public function returnOperacionesSucursal($fecha,$idSucursal,$pag){
    $pagina = ($pag - 1) * 50;
    $consulta = conectarDB(" SELECT O.* FROM `operaciones` O
    
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal`
    WHERE O.`fecha`='$fecha' AND S.`idSucursal` = '$idSucursal'
    ORDER BY `idOperacion` DESC
    LIMIT 50
    OFFSET $pagina
    ");
    $ops = [];
    $cont = 0;
    foreach($consulta as $c){
     
      $op = new Operacion;
      $op->idOperacion = $c['idOperacion'];
      $op->idUsuario = $c['idUsuario'];
      $op->fecha = $c['fecha'];
      $op->hora = $c['hora'];
      $op->tipoOperacion = $c['tipoOperacion'];
      $op->idMoneda = $c['idMoneda'];
      $op->monto = $c['monto'];
      $op->cotizacion = $c['cotizacion'];
      $op->estado = $c['estado'];
      switch ($op->tipoOperacion) {
        case 1: $op->detalle = "Compra";
          break;
        case 2: $op->detalle = "Venta";
          break;
        case 3:           $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
        if($consulta2->num_rows>0){
          $c2 = mysqli_fetch_assoc($consulta2);
          $op->detalle = $c2['detalle'];
        }
          break;
        case 4:           $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
        if($consulta2->num_rows>0){
          $c2 = mysqli_fetch_assoc($consulta2);
          $op->detalle = $c2['detalle'];
        }
          break;
        case 5:
          $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
          if($consulta2->num_rows>0){
            $c2 = mysqli_fetch_assoc($consulta2);
            $op->detalle = $c2['detalle'];
          }
          break;
        default: $op->detalle = "";
          break;
          
      }
      
      $ops[] = $op;
    }
    
    return $ops;  
  }
  public function returnCantidadOperacionesSucursal($fecha,$idSucursal){
    $consulta = conectarDB(" SELECT COUNT(*) as 'cantidad'
    FROM `operaciones` O 
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario` 
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`fecha`='$fecha' AND S.`idSucursal` = '$idSucursal' 
    ORDER BY `idOperacion` DESC;
    ");

    $c = mysqli_fetch_assoc($consulta);
    return $c['cantidad'];  
  }
  public function returnOperacionesGeneral($fecha){
    $consulta = conectarDB(" SELECT * FROM `operaciones` 
    WHERE `fecha`='$fecha' 
    ORDER BY `idOperacion` DESC
    LIMIT 50
    OFFSET 0
    ");
    $ops = [];
    $cont = 0;
    foreach($consulta as $c){
     
      $op = new Operacion;
      $op->idOperacion = $c['idOperacion'];
      $op->idUsuario = $c['idUsuario'];
      $op->fecha = $c['fecha'];
      $op->hora = $c['hora'];
      $op->tipoOperacion = $c['tipoOperacion'];
      $op->idMoneda = $c['idMoneda'];
      $op->monto = $c['monto'];
      $op->cotizacion = $c['cotizacion'];
      $op->estado = $c['estado'];
      switch ($op->tipoOperacion) {
        case 1: $op->detalle = "Compra";
          break;
        case 2: $op->detalle = "Venta";
          break;
        case 3:           $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
        if($consulta2->num_rows>0){
          $c2 = mysqli_fetch_assoc($consulta2);
          $op->detalle = $c2['detalle'];
        }
          break;
        case 4:           $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
        if($consulta2->num_rows>0){
          $c2 = mysqli_fetch_assoc($consulta2);
          $op->detalle = $c2['detalle'];
        }
          break;
        case 5:
          $consulta2 = conectarDB("SELECT * FROM `detalles` WHERE `idOperacion`='$op->idOperacion' ");
          if($consulta2->num_rows>0){
            $c2 = mysqli_fetch_assoc($consulta2);
            $op->detalle = $c2['detalle'];
          }
          break;
        default: $op->detalle = "";
          break;
          
      }
      
      $ops[] = $op;
    }
    
    return $ops;  
  }
  public function deleteOperacion(int $id, string $code){
    $codigo = conectarDB("SELECT * FROM `token`");
    $c = mysqli_fetch_assoc($codigo);
    if($c['token'] == $code){
      // error("CODIGO correcto");
      $consulta = conectarDB("UPDATE `operaciones` SET
    `estado`='0'
    WHERE `idOperacion` = '$id' 
    ");
     $token = token();
     conectarDB("UPDATE `token` SET `token`='$token', `fecha_hora` = NOW() ");

    }else{
      error("CODIGO INCORRECTO");
    }
    
  }

  // DOLARES

  public function compraDelDia($sucursal=0, $fecha, $moneda){
    $comprado = 0;
    $usuarios = new Usuarios;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
        
      }
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
      }
    }
    return $comprado;
  }
  public function ventaDelDia($sucursal=0, $fecha, $moneda){
    $comprado = 0;
    $usuarios = new Usuarios;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
        
      }
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
      }
    }
    return $comprado;
  }
  public function spreadDelDia($sucursal=0, $fecha, $moneda){
    $spread = 0;
    $usuarios = new Usuarios;
    $totalCompra = 0;
    $totalVenta = 0;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){ //compras
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $totalCompra += $c['monto'] * $c['cotizacion'];
        }
        
      }
      foreach($usuarios as $usuario){ //ventas
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $totalVenta += $c['monto'] * $c['cotizacion'];
        }
        
      }
      try{
        $spread = ($totalVenta/$this->ventaDelDia($sucursal,$fecha,$moneda))-($totalCompra/$this->compraDelDia($sucursal,$fecha,$moneda));

      }catch(Throwable $th){

      }
   
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $totalCompra += $c['monto'] * $c['cotizacion'];
        }
        
      }
      foreach($usuarios as $usuario){ //ventas
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        `fecha` = '$fecha'");
        foreach($consulta as $c){
          $totalVenta += $c['monto'] * $c['cotizacion'];
        }
        
      }
      try {
        //code...
      $spread = ($totalVenta/$this->ventaDolaresDelDia($sucursal,$fecha))-($totalCompra/$this->compraDolaresDelDia($sucursal,$fecha));

      } catch (\Throwable $th) {
        //throw $th;
      }
      
    }
    return number_format($spread,2);
  }
  public function gananciaBrutaDelDia($sucursal=0, $fecha, $moneda){
    // Inicializar Ganancia en 0
    $ganancia = 0;
    if($this->compraDelDia($sucursal, $fecha, $moneda) == $this->ventaDelDia($sucursal, $fecha, $moneda)){
      //SE COMPRA LO MISMO QUE SE VENDE
      $ganancia = $this->ventaDelDia($sucursal, $fecha, $moneda) * $this->spreadDelDia($sucursal, $fecha, $moneda);
    }else{
      if($this->compraDelDia($sucursal, $fecha, $moneda) > $this->ventaDelDia($sucursal, $fecha, $moneda)){
        //SE COMPRA MAS DE LO QUE SE VENDE
  
      }
      if($this->compraDelDia($sucursal, $fecha, $moneda) < $this->ventaDelDia($sucursal, $fecha, $moneda)){
        //SE COMPRA MENOS DE LO QUE SE VENDE
      }
    }
    return $ganancia;
  }
  public function diferenciaDeStockDelDia($sucursal, $fecha, $moneda){
    
    return 0;
  }
  public function gananciaNetaDelDia($sucursal=0, $fecha, $moneda){
    return $this->gananciaBrutaDelDia($sucursal, $fecha, $moneda) - $this->diferenciaDeStockDelDia($sucursal, $fecha, $moneda);
  }
  public function compraDelMes($sucursal=0, $fecha, $moneda){
    $mes = $fecha[5].$fecha[6];
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    $comprado = 0;
    $usuarios = new Usuarios;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
        
      }
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
      }
    }
    return $comprado;
  }
  public function ventaDelMes($sucursal=0, $fecha, $moneda){
    $mes = $fecha[5].$fecha[6];
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    $comprado = 0;
    $usuarios = new Usuarios;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
        
      }
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
      }
    }
    return $comprado;
  }
  public function spreadDelMes($sucursal=0, $fecha, $moneda){
    $mes = $fecha[5].$fecha[6];
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    $spread = 0;
    $usuarios = new Usuarios;
    $totalCompra = 0;
    $totalVenta = 0;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){ //compras
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'");
        foreach($consulta as $c){
          $totalCompra += $c['monto'] * $c['cotizacion'];
        }
        
      }
      foreach($usuarios as $usuario){ //ventas
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'");
        foreach($consulta as $c){
          $totalVenta += $c['monto'] * $c['cotizacion'];
        }
        
      }
      try{
        $spread = ($totalVenta/$this->ventaDelMes($sucursal,$fecha,$moneda))-($totalCompra/$this->compraDelMes($sucursal,$fecha,$moneda));

      }catch(Throwable $th){

      }
   
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'");
        foreach($consulta as $c){
          $totalCompra += $c['monto'] * $c['cotizacion'];
        }
        
      }
      foreach($usuarios as $usuario){ //ventas
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio' AND
        MONTH(`fecha`) = '$mes'");
        foreach($consulta as $c){
          $totalVenta += $c['monto'] * $c['cotizacion'];
        }
        
      }
      try {
        //code...
      $spread = ($totalVenta/$this->ventaDolaresDelMes($sucursal,$fecha))-($totalCompra/$this->compraDolaresDelMes($sucursal,$fecha));

      } catch (\Throwable $th) {
        //throw $th;
      }
      
    }
    return number_format($spread,2);
  }
  public function gananciaBrutaDelMes($sucursal=0, $fecha, $moneda){
    // Inicializar Ganancia en 0
    $ganancia = 0;
    $ganancia = $this->ventaDelMes($sucursal, $fecha, $moneda) * $this->spreadDelMes($sucursal, $fecha, $moneda);   
    return $ganancia;
  }
  public function compraDelAnio($sucursal=0, $fecha, $moneda){
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    $comprado = 0;
    $usuarios = new Usuarios;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
        
      }
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
      }
    }
    return $comprado;
  }
  public function ventaDelAnio($sucursal=0, $fecha, $moneda){
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    $comprado = 0;
    $usuarios = new Usuarios;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
        
      }
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'
        ");
        foreach($consulta as $c){
          $comprado += $c['monto'];
        }
      }
    }
    return $comprado;
  }
  public function spreadDelAnio($sucursal=0, $fecha, $moneda){
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    $spread = 0;
    $usuarios = new Usuarios;
    $totalCompra = 0;
    $totalVenta = 0;
    if($sucursal == 0){
      $usuarios = $usuarios->returnUsuarios();
      foreach($usuarios as $usuario){ //compras
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'");
        foreach($consulta as $c){
          $totalCompra += $c['monto'] * $c['cotizacion'];
        }
        
      }
      foreach($usuarios as $usuario){ //ventas
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'");
        foreach($consulta as $c){
          $totalVenta += $c['monto'] * $c['cotizacion'];
        }
        
      }
      try{
        $spread = ($totalVenta/$this->ventaDelAnio($sucursal,$fecha,$moneda))-($totalCompra/$this->compraDelAnio($sucursal,$fecha,$moneda));

      }catch(Throwable $th){

      }
   
    }else{
      $usuarios = $usuarios->returnUsuariosSucursal($sucursal);
      foreach($usuarios as $usuario){
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 1 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'");
        foreach($consulta as $c){
          $totalCompra += $c['monto'] * $c['cotizacion'];
        }
        
      }
      foreach($usuarios as $usuario){ //ventas
        $consulta = conectarDB("SELECT * FROM `operaciones` WHERE 
        `tipoOperacion` = 2 AND
        `idMoneda` = '$moneda' AND
        `estado` = 1 AND
        `idUsuario` = '$usuario->idUsuario' AND
        YEAR(`fecha`) = '$anio'");
        foreach($consulta as $c){
          $totalVenta += $c['monto'] * $c['cotizacion'];
        }
        
      }
      try {
        //code...
      $spread = ($totalVenta/$this->ventaDolaresDelAnio($sucursal,$fecha))-($totalCompra/$this->compraDolaresDelAnio($sucursal,$fecha));

      } catch (\Throwable $th) {
        //throw $th;
      }
      
    }
    return number_format($spread,2);
  }
  public function gananciaBrutaDelAnio($sucursal=0, $fecha, $moneda){
    // Inicializar Ganancia en 0
    $ganancia = 0;
    $ganancia = $this->ventaDelAnio($sucursal, $fecha, $moneda) * $this->spreadDelAnio($sucursal, $fecha, $moneda);   
    return $ganancia;
  }
  public function diaDeLaSemanaQueMasSeCompra($sucursal = 0 , $moneda = 2){
    $dias = array(
      'Lunes' => 0,
      'Martes' => 0,
      'Miercoles' => 0,
      'Jueves' => 0,
      'Viernes' => 0,
      'Sabado' => 0,
      'Domingo' => 0,
    );
    if($sucursal == 0){
      $consulta = conectarDB("SELECT * FROM `operaciones` O
      WHERE O.`estado` = 1 AND O.`tipoOperacion` = 1 AND O.`idMoneda` = $moneda");
    }else{
      $consulta = conectarDB("SELECT * FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`  
      WHERE O.`estado` = 1 AND O.`tipoOperacion` = 1 AND O.`idMoneda` = $moneda AND U.`idSucursal`= $sucursal ");
    }

    foreach($consulta as $c){
      switch(date('N', strtotime($c['fecha']))){
        case 1: $dias['Lunes']+=$c['monto'];
          break;
        case 2: $dias['Martes']+=$c['monto'];
          break;
        case 3: $dias['Miercoles']+=$c['monto'];
          break;
        case 4: $dias['Jueves']+=$c['monto'];
          break;
        case 5: $dias['Viernes']+=$c['monto'];
          break;
        case 6: $dias['Sabado']+=$c['monto'];
          break;
        case 7: $dias['Domingo']+=$c['monto'];
          break;
      }
    }
    //ver($dias);
    return array_search(max($dias),$dias);
  }
  public function diaDeLaSemanaQueMasSeVende($sucursal = 0 , $moneda = 2){
    $dias = array(
      'Lunes' => 0,
      'Martes' => 0,
      'Miercoles' => 0,
      'Jueves' => 0,
      'Viernes' => 0,
      'Sabado' => 0,
      'Domingo' => 0,
    );
    if($sucursal == 0){
      $consulta = conectarDB("SELECT * FROM `operaciones` O
      WHERE O.`estado` = 1 AND O.`tipoOperacion` = 1 AND O.`idMoneda` = $moneda");
    }else{
      $consulta = conectarDB("SELECT * FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`  
      WHERE O.`estado` = 1 AND O.`tipoOperacion` = 2 AND O.`idMoneda` = $moneda AND U.`idSucursal`= $sucursal ");
    }

    foreach($consulta as $c){
      switch(date('N', strtotime($c['fecha']))){
        case 1: $dias['Lunes']+=$c['monto'];
          break;
        case 2: $dias['Martes']+=$c['monto'];
          break;
        case 3: $dias['Miercoles']+=$c['monto'];
          break;
        case 4: $dias['Jueves']+=$c['monto'];
          break;
        case 5: $dias['Viernes']+=$c['monto'];
          break;
        case 6: $dias['Sabado']+=$c['monto'];
          break;
        case 7: $dias['Domingo']+=$c['monto'];
          break;
      }
    }
    //ver($dias);
    return array_search(max($dias),$dias);
  }
  public function diaDelMesQueMasSeCompra($sucursal = 0, $fecha, $moneda = 2, ){
    $mes = $fecha[5].$fecha[6];
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    if($sucursal == 0){
      $consulta = conectarDB("SELECT `fecha`, SUM(`monto`) AS suma_montos FROM `operaciones` WHERE 
      `tipoOperacion` = 1 AND
      `idMoneda` = '$moneda' AND
      `estado` = 1 AND
      YEAR(`fecha`) = '$anio' AND
      MONTH(`fecha`) = '$mes'
      GROUP BY DATE_FORMAT(`fecha`, '%Y-%m-%d')
      ORDER BY suma_montos DESC
      LIMIT 1 ");
    }else{
      $consulta = conectarDB("SELECT O.`fecha`, SUM(`monto`) AS suma_montos
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario` WHERE
      O.`tipoOperacion` = 1 AND
      O.`idMoneda` = '$moneda' AND
      O.`estado` = 1 AND
      U.`idSucursal` = '$sucursal' AND
      YEAR(O.`fecha`) = '$anio' AND
      MONTH(O.`fecha`) = '$mes'
      GROUP BY DATE_FORMAT(`fecha`, '%Y-%m-%d')
      ORDER BY suma_montos DESC
      LIMIT 1 ");
    }
    foreach($consulta as $c){
      return date('d/m/Y', strtotime($c['fecha']));
    }
  }
  public function diaDelMesQueMasSeVende($sucursal = 0, $fecha, $moneda = 2, ){
    $mes = $fecha[5].$fecha[6];
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    if($sucursal == 0){
      $consulta = conectarDB("SELECT `fecha`, SUM(`monto`) AS suma_montos FROM `operaciones` WHERE 
      `tipoOperacion` = 2 AND
      `idMoneda` = '$moneda' AND
      `estado` = 1 AND
      YEAR(`fecha`) = '$anio' AND
      MONTH(`fecha`) = '$mes'
      GROUP BY DATE_FORMAT(`fecha`, '%Y-%m-%d')
      ORDER BY suma_montos DESC
      LIMIT 1 ");
    }else{
      $consulta = conectarDB("SELECT O.`fecha`, SUM(`monto`) AS suma_montos
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario` WHERE
      O.`tipoOperacion` = 2 AND
      O.`idMoneda` = '$moneda' AND
      O.`estado` = 1 AND
      U.`idSucursal` = '$sucursal' AND
      YEAR(O.`fecha`) = '$anio' AND
      MONTH(O.`fecha`) = '$mes'
      GROUP BY DATE_FORMAT(`fecha`, '%Y-%m-%d')
      ORDER BY suma_montos DESC
      LIMIT 1 ");
    }
    foreach($consulta as $c){
      return date('d/m/Y', strtotime($c['fecha']));
    }
  }
  public function comprasVentasDelAnio($sucursal = 0, $anio = 2023, $moneda = 2, $operacion = 1){
    if($sucursal == 0 ){
      $consulta = conectarDB("SELECT DATE_FORMAT(O.`fecha`, '%c') AS mes, SUM(`monto`) AS montos
      FROM `operaciones` O WHERE
      O.`tipoOperacion` = '$operacion' AND
      O.`idMoneda` = '$moneda' AND
      O.`estado` = 1 AND
      YEAR(O.`fecha`) = '$anio'
      GROUP BY DATE_FORMAT(`fecha`, '%c')
      ORDER BY montos DESC
     ");      
    }else{
      $consulta = conectarDB("SELECT DATE_FORMAT(O.`fecha`, '%c') AS mes, SUM(`monto`) AS montos
      FROM `operaciones` O  INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario` WHERE
      O.`tipoOperacion` = '$operacion' AND
      O.`idMoneda` = '$moneda' AND
      U.`idSucursal` = '$sucursal' AND
      O.`estado` = 1 AND
      YEAR(O.`fecha`) = '$anio'
      GROUP BY DATE_FORMAT(`fecha`, '%c')
      ORDER BY montos DESC
     ");  
    }
    $meses = [0,0,0,0,0,0,0,0,0,0,0,0];
    foreach($consulta as $op){
      $meses[$op['mes']-1] = $op['montos'];
    
    }
    
    return $meses;
  }
  public function comprasVentasDelMes($sucursal = 0, $fecha, $moneda = 2, $operacion = 1){
    $mes = $fecha[5].$fecha[6];
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    if($sucursal == 0 ){
      $consulta = conectarDB("SELECT DATE_FORMAT(O.`fecha`, '%d') AS mes, SUM(`monto`) AS montos
      FROM `operaciones` O WHERE
      O.`tipoOperacion` = '$operacion' AND
      O.`idMoneda` = '$moneda' AND
      O.`estado` = 1 AND
      YEAR(O.`fecha`) = '$anio' AND
      MONTH(O.`fecha`) = '$mes'
      GROUP BY DATE_FORMAT(`fecha`, '%d')
      ORDER BY montos DESC
     ");      
    }else{
      $consulta = conectarDB("SELECT DATE_FORMAT(O.`fecha`, '%d') AS mes, SUM(`monto`) AS montos
      FROM `operaciones` O  INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario` WHERE
      O.`tipoOperacion` = '$operacion' AND
      O.`idMoneda` = '$moneda' AND
      U.`idSucursal` = '$sucursal' AND
      O.`estado` = 1 AND
      YEAR(O.`fecha`) = '$anio' AND
      MONTH(O.`fecha`) = '$mes'
      GROUP BY DATE_FORMAT(`fecha`, '%d')
      ORDER BY montos DESC
     ");  
    }
    $dias = llenarArrayConCeros(obtenerDiasEnMes($fecha));
    foreach($consulta as $op){
      $dias[$op['mes']-1] = $op['montos'];
    
    }
    
    return $dias;
  }
}