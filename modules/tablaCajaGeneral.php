
<?php
require "./../app/app.php";

$fecha = $_GET['fecha'];
$pag = 1;
$operaciones = new Operaciones;
$operaciones =$operaciones-> returnOperacionesGeneral($fecha);
$totalPesos = 0;
$totalDolares = 0;
$totalEuros = 0;
?>
<table class="tftable Caja" border="1px" style="overflow-x: hidden;">
    <tr class="titulo">
      <th>DETALLE</th>
      <th>USD <img src="img/usd.png" alt=""></th>
      <th>EUR <img src="img/eur.png" alt=""></th>
      <th>COT</th>
      <th>ARS <img src="img/arg.png" alt=""></th>
      <th>Fecha</th>
      <th>Hora</th>
      <th>Sucursal</th>
      <th>Usuario</th>
      <th>ID</th>
      <th></th>
    </tr>
    <?php foreach($operaciones as $op){
      $user = new Usuarios;
      $user = $user->returnUsuario($op->idUsuario);  
      $suc = new Sucursales;
      $suc = $suc->returnSucursal($user->idSucursal);
    ?>
    <tr class="<?php if($op->estado == 0){echo "eliminado";} ?>">
    <?php
        $pesos = 0;
        $dolares = 0;
        $euros = 0;

        $cPesos = "";
        $cDolares = "";
        $cEuros = "";
        switch ($op->tipoOperacion) {
          case 1://compra
            $pesos = $op->monto * $op->cotizacion * -1;
            if($op->idMoneda==2){
              $dolares = $op->monto;
              $cPesos = "cRojo";
              $cDolares = "cVerde";
              $cEuros = "cGris";
            }
            if($op->idMoneda==3){
              $euros = $op->monto;
              $cPesos = "cRojo";
              $cDolares = "cGris";
              $cEuros = "cVerde";
            }
            break;
          case 2://venta
            $pesos = $op->monto * $op->cotizacion;
            if($op->idMoneda==2){
              $dolares = $op->monto*-1;
              $cPesos = "cVerde";
              $cDolares = "cRojo";
              $cEuros = "cGris";
            }
            if($op->idMoneda==3){
              $euros = $op->monto*-1;
              $cPesos = "cVerde";
              $cDolares = "cGris";
              $cEuros = "cRojo";
            }
            break;
          default://ingreso //egreso //personalizado
            if($op->idMoneda==1){
              $pesos = $op->monto;
              
              if($pesos>0){
                $cPesos = "cVerde";
              }else{$cPesos = "cRojo";}
              $cDolares = "cGris";
              $cEuros = "cGris";
            }
            if($op->idMoneda==2){
              $dolares = $op->monto;
              if($dolares>0){
                $cDolares = "cVerde";
              }else{$cDolares = "cRojo";}
              $cPesos = "cGris";
              $cEuros = "cGris";
            }
            if($op->idMoneda==3){
              $euros = $op->monto;
              if($euros>0){
                $cEuros = "cVerde";
              }else{$cEuros = "cRojo";}
              $cPesos = "cGris";
              $cDolares = "cGris";
              
            }
            break;
        }
        if($op->estado){
          $totalPesos += $pesos;
          $totalDolares += $dolares;
          $totalEuros += $euros;
        }

      ?>    
      <td><?php echo $op->detalle ?></td>  
      <td class="<?php echo $cDolares ?>"><?php echo 'U$D '.number_format($dolares, 2, ',', '.'); ?></td>
      <td class="<?php echo $cEuros ?>"><?php echo "€ ".number_format($euros, 2, ',', '.'); ?></td>
      <td><?php echo $op->cotizacion ?></td> 
      <td class="<?php echo $cPesos ?>"><?php echo "$ ".number_format($pesos, 2, ',', '.'); ?></td>

      <td><?php echo date('d/m/Y', strtotime($op->fecha))  ?></td>
      <td><?php echo $op->hora ?></td>
      <td><?php echo $suc->nombre ?></td>
      <td><?php echo $user->nombre ?></td>
      <td><?php echo $op->idOperacion ?></td>


      <td class="trash">
        <?php if($op->estado == 1){ ?>
        <button onClick="eliminar('<?php echo $op->idOperacion; ?>')">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M4 7l16 0" />
          <path d="M10 11l0 6" />
          <path d="M14 11l0 6" />
          <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
          <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
        </svg>
        </button>
        <?php } ?>
      </td>
    </tr>
    <?php }?>
    
    <tr>
      <th>TOTAL</th>
      <th><?php echo 'U$D '.number_format($totalDolares, 2, ',', '.'); ?></th>
      <th><?php echo "€ ".number_format($totalEuros, 2, ',', '.'); ?></th>
      <th></th>
      <th><?php echo "$ ".number_format($totalPesos, 2, ',', '.'); ?></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>


</table>


