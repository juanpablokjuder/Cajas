<?php // Contenido del script PHP para generar el resultado deseado
$fecha = $_GET['fecha'];
$hora = $_GET['hora'];
$operacion = $_GET['operacion'];
$moneda = $_GET['moneda'];
$monto = $_GET['monto'];
$cot = $_GET['cot'];
$total = $_GET['total'];
$html = "
            Ticket
------------------------------
Fecha:              {$fecha}
Hora:                 {$hora}  
------------------------------
Operacion:            ({$operacion})
{$moneda}                        {$monto}
COT                       {$cot}
------------------------------
Total:                  {$total}
";
file_put_contents("ticket.html", $html);
//exec('PRINT /d:COM5 "E:\Repositorio\Cajas\ticket.pdf"');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
  *{
    font-weight: 700;
  }
  h1{
    font-size: 20px;
    text-align: center;
    margin:0px;
    font-family: 'Karla', sans-serif;
    font-family: 'League Gothic', sans-serif;
  }
  hr{
    height: 2px;
    background-color: #111;
    color: #111;
  }
  .detalle{
    display: flex;
    justify-content: space-between;
    width: 100%;
    align-items:center;
  }
  p{
    margin: 8px 0px;
  }
  .logo{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px 0px;
  }
  .logo>img{
    width: 100px;
  }
</style>
</head>
<body>

<div>
    <h1>Ticket</h1>
    <p>-------------------------------</p>
    <p>Fecha: <?php echo $fecha ?></p>
    <p>Hora: <?php echo $hora ?></p>
    <p>-------------------------------</p>
    <div class='detalle'>
      <p>Operacion:</p>
      <p>(<?php echo $operacion ?>)</p>
    </div>
    <div class='detalle'>
      <p class='moneda'> <?php echo $moneda?></p>
      <p class='operacion'><?php echo $monto ?></p>
    </div>
    <div class='detalle'>
      <p>Cot</p>
      <p><?php echo $cot ?></p>
    </div>
    <p>-------------------------------</p>
    <div class='detalle'>
      <p>Total:</p>
      <p>$<?php echo $total ?></p>
    </div>

</div>

</body>
</html>
<script>
window.onload = function() {
  window.print();
  //console.log("imprimiendo...")
  windows.close();
}
window.onafterprint = function() {
    // Se ejecuta después de que se completa la impresión
    console.log("Después de imprimir");
    windows.close();
};
windows.close();
</script>