
<?php
require "./../app/app.php";

$fecha = $_GET['fecha'];
$idSucursal= $_GET['sucursal'];
$pag = 1;
$operaciones = new Operaciones;
$operaciones =$operaciones-> returnOperacionesSucursal($fecha,$idSucursal,$pag);
$totalPesos = 0;
$totalDolares = 0;
$totalEuros = 0;
?>
<table class="tftable Caja" border="1px" style="overflow-x: hidden;" id="tblSimulador">
    <tr class="titulo">
      <th>DETALLE</th>
      <th>USD <img src="img/usd.png" alt=""></th>
      <th>EUR <img src="img/eur.png" alt=""></th>
      <th>COT</th>
      <th>ARS <img src="img/arg.png" alt=""></th>
      <th>Usuario</th>
      <th>Fecha</th>
      <th>Hora</th>
      <th>ID</th>    
     
    </tr>
    <tr class="">
      <td><select id="slcOperacion">
        <option value="1">Compra</option>
        <option value="2">Venta</option>
      </select></td>
      <td><input type="text" id="inUSD" onInput="formatoInput(this)"></td>
      <td><input type="text" id="inEUR" onInput="formatoInput(this)"></td>
      <td><input type="text" id="inCOT"></td>
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>   <button onclick="GuardarOperacion()" class="btn" type="button">Guardar</button></td>    

    </tr>
    <?php foreach($operaciones as $op){
        $user = new Usuarios;
        $user = $user->returnUsuario($op->idUsuario);  
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
      <td><?php echo $user->nombre ?></td>
      <td><?php echo date('d/m/Y', strtotime($op->fecha)) ?></td>
      <td><?php echo $op->hora ?></td>
      <td><?php echo $op->idOperacion ?></td>




      
    </tr>
    <?php }?>
    
    <!-- <tr>
      <th>TOTAL</th>
      <th><?php echo 'U$D '.number_format($totalDolares, 2, ',', '.'); ?></th>
      <th><?php echo "€ ".number_format($totalEuros, 2, ',', '.'); ?></th>
      <th></th>
      <th><?php echo "$ ".number_format($totalPesos, 2, ',', '.'); ?></th>
      <th></th>
      <th></th>
      <th></th>

      <th></th>
    </tr> -->


</table>