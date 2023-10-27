<?php
require "app/app.php";
validarGerenteGeneral();
if($_SERVER['REQUEST_METHOD']=="POST"){

  $cot = new Cotizacion;
  $cot->idMoneda = $_POST['idMoneda'];
  $cot->idUsuario = $_POST['idUsuario'];
  $cot->compra = $_POST['compra'];
  $cot->venta = $_POST['venta'];

  
  $cotizacion = new Cotizaciones;
  $cotizacion->insertCotizacion($cot);
  header("location: ./cotizacion.php");
}
html("Caja");
 menu();
//  ver($_SESSION);
//  ver($_POST);

?>
<div class="contenedor">
        <h2>Cotizaciones</h2>
</div>

<?php 

  $consulta = conectarDB("SELECT * FROM `monedas` WHERE `idMoneda` != 1");
  foreach($consulta as $moneda){
    $cotizacion = new Cotizaciones;
    $cotizacion = $cotizacion->returnUltimaCotizacionMoneda($moneda['idMoneda']);
    $compra = $cotizacion->compra;
    $venta = $cotizacion->venta;
?>
  <div class="contenedor">
        <h2><?php echo $moneda['nombre'] ?></h2>
        <form action="" method="POST" class="formCot">
          <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['idUsuario'] ?>" >
          <input type="hidden" name="idMoneda" value="<?php echo $moneda['idMoneda'] ?>">
          <h3>Compra</h3>
          <input type="number" name="compra" value="<?php echo $compra ?>">
          <h3>Venta</h3>
          <input type="number" name="venta" value="<?php echo $venta ?>">
          <button type="submit" class="btn">Guardar</button>
        </form>
  </div>
<?php
  }
?>