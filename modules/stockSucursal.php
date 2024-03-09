<?php
require "./../app/app.php";

$saldo = 0;
$idSucursal = $_GET['sucursal'];
$tipo = $_GET['tipo'];
$moneda = $_GET['moneda'];
$fecha = $_GET['fecha'] == null ? "" : $_GET['fecha'];
if($tipo == "Actual"){
  if($_GET['moneda'] == "1"){
    //pesos
    //todas las compras ventas ingresos egresos y personalizados
    $compras = conectarDB("SELECT SUM(O.`monto`*O.`cotizacion`) as 'saldo'
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND S.`idSucursal` = '$idSucursal' ");
    $compra = mysqli_fetch_assoc($compras);
    $saldo -= $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(O.`monto`*O.`cotizacion`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND S.`idSucursal` = '$idSucursal'");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo += $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal'");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal'");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal'");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];
  
  
     echo "$".number_format($saldo, 2, ',', '.');
  }
  if($_GET['moneda'] == "2"){
    //dolares
      //todas las compras ventas ingresos egresos y personalizados
      $compras = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal'");
      $compra = mysqli_fetch_assoc($compras);
      $saldo += $compra['saldo'];
      
      $ventas = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal'");
      $venta = mysqli_fetch_assoc($ventas);
      $saldo -= $venta['saldo'];
    
      $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal'");
      $ingreso = mysqli_fetch_assoc($ingresos);
      $saldo += $ingreso['saldo'];
      
      $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal'");
      $egreso = mysqli_fetch_assoc($egresos);
      $saldo += $egreso['saldo'];
    
      $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal'");
      $personalizado = mysqli_fetch_assoc($personalizados);
      $saldo += $personalizado['saldo'];
    
    
       echo '$'.number_format($saldo, 2, ',', '.');
    // echo "2";
  }
  if($_GET['moneda'] == "3"){
    //euros
    $compras = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal'");
    $compra = mysqli_fetch_assoc($compras);
    $saldo += $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal'");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo -= $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal'");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O 
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal'");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal'");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];
  
  
     echo "€".number_format($saldo, 2, ',', '.');
    // echo "3";
  }
}
if($tipo == "Inicial"){
  if($_GET['moneda'] == "1"){
    //pesos
    //todas las compras ventas ingresos egresos y personalizados
    $compras = conectarDB("SELECT SUM(O.`monto`*O.`cotizacion`) as 'saldo'
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $compra = mysqli_fetch_assoc($compras);
    $saldo -= $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(O.`monto`*O.`cotizacion`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo += $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];
  
  
     echo "$".number_format($saldo, 2, ',', '.');
  }
  if($_GET['moneda'] == "2"){
    //dolares
      //todas las compras ventas ingresos egresos y personalizados
      $compras = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
      $compra = mysqli_fetch_assoc($compras);
      $saldo += $compra['saldo'];
      
      $ventas = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
      $venta = mysqli_fetch_assoc($ventas);
      $saldo -= $venta['saldo'];
    
      $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
      $ingreso = mysqli_fetch_assoc($ingresos);
      $saldo += $ingreso['saldo'];
      
      $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
      $egreso = mysqli_fetch_assoc($egresos);
      $saldo += $egreso['saldo'];
    
      $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
      $personalizado = mysqli_fetch_assoc($personalizados);
      $saldo += $personalizado['saldo'];
    
    
       echo '$'.number_format($saldo, 2, ',', '.');
    // echo "2";
  }
  if($_GET['moneda'] == "3"){
    //euros
    $compras = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $compra = mysqli_fetch_assoc($compras);
    $saldo += $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo -= $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O 
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` < '$fecha'");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];
  
  
     echo "€".number_format($saldo, 2, ',', '.');
    // echo "3";
  }
}
if($tipo == "Final"){
  if($_GET['moneda'] == "1"){
    //pesos
    //todas las compras ventas ingresos egresos y personalizados
    $compras = conectarDB("SELECT SUM(O.`monto`*O.`cotizacion`) as 'saldo'
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha' ");
    $compra = mysqli_fetch_assoc($compras);
    $saldo -= $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(O.`monto`*O.`cotizacion`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo += $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 1 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];
  
  
     echo "$".number_format($saldo, 2, ',', '.');
  }
  if($_GET['moneda'] == "2"){
    //dolares
      //todas las compras ventas ingresos egresos y personalizados
      $compras = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
      $compra = mysqli_fetch_assoc($compras);
      $saldo += $compra['saldo'];
      
      $ventas = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
      $venta = mysqli_fetch_assoc($ventas);
      $saldo -= $venta['saldo'];
    
      $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
      $ingreso = mysqli_fetch_assoc($ingresos);
      $saldo += $ingreso['saldo'];
      
      $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
      $egreso = mysqli_fetch_assoc($egresos);
      $saldo += $egreso['saldo'];
    
      $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
      FROM `operaciones` O
      INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
      INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
      WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 2 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
      $personalizado = mysqli_fetch_assoc($personalizados);
      $saldo += $personalizado['saldo'];
    
    
       echo '$'.number_format($saldo, 2, ',', '.');
    // echo "2";
  }
  if($_GET['moneda'] == "3"){
    //euros
    $compras = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 1 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $compra = mysqli_fetch_assoc($compras);
    $saldo += $compra['saldo'];
    
    $ventas = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 2 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $venta = mysqli_fetch_assoc($ventas);
    $saldo -= $venta['saldo'];
  
    $ingresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 3 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $ingreso = mysqli_fetch_assoc($ingresos);
    $saldo += $ingreso['saldo'];
    
    $egresos = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O 
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 4 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $egreso = mysqli_fetch_assoc($egresos);
    $saldo += $egreso['saldo'];
  
    $personalizados = conectarDB("SELECT SUM(O.`monto`) as 'saldo' 
    FROM `operaciones` O
    INNER JOIN `usuarios` U ON U.`idUsuario` = O.`idUsuario`
    INNER JOIN `sucursales` S ON U.`idSucursal` = S.`idSucursal` 
    WHERE O.`tipoOperacion` = 5 AND O.`Estado` = 1 AND O.`idMoneda` = 3 AND S.`idSucursal` = '$idSucursal' AND `fecha` <= '$fecha'");
    $personalizado = mysqli_fetch_assoc($personalizados);
    $saldo += $personalizado['saldo'];
  
  
     echo "€".number_format($saldo, 2, ',', '.');
    // echo "3";
  }
}