

<?php
// Contenido del script PHP para generar el resultado deseado
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

// 


// require_once 'vendor/autoload.php';
// use Dompdf\Dompdf;
// $dompdf = new Dompdf();
// $dompdf->loadHtml("<!DOCTYPE html>
// <html lang='en'>
// <head>
//   <meta charset='UTF-8'>
//   <meta http-equiv='X-UA-Compatible' content='IE=edge'>
//   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
//   <title>Document</title>
//   <style>
//   *{
//     font-weight: 700;
//   }
//   h1{
//     font-size: 20px;
//     text-align: center;
//     margin:0px;
//     font-family: 'Karla', sans-serif;
//     font-family: 'League Gothic', sans-serif;
//   }
//   hr{
//     height: 2px;
//     background-color: #111;
//     color: #111;
//   }
//   .detalle{
//     display: flex;
//     justify-content: space-between;
//     width: 100%;
//     align-items:center;
//   }
//   p{
//     margin: 8px 0px;
//   }
//   .logo{
//     width: 100%;
//     display: flex;
//     align-items: center;
//     justify-content: center;
//     margin: 10px 0px;
//   }
//   .logo>img{
//     width: 50px;
//   }
// </style>
// </head>
// <body>
// <div>
//     <h1>Ticket</h1>
//     <p>-------------------------------</p>
//     <p>Fecha: 02/03/2023</p>
//     <p>Hora: 14:15:10</p>
//     <p>-------------------------------</p>
//     <div class='detalle'>
//       <p>Operacion:</p>
//       <p>(compra)</p>
//     </div>
//     <div class='detalle'>
//       <p class='moneda'> USD</p>
//       <p class='operacion'>10000</p>
//     </div>
//     <div class='detalle'>
//       <p>Cot</p>
//       <p>1050</p>
//     </div>
//     <p>-------------------------------</p>
//     <div class='detalle'>
//       <p>Total:</p>
//       <p>$10500000</p>
//     </div>

// </div>
// </body>
// </html>

// ");
// $dompdf->setPaper('ticket', 'portrait');
// $dompdf->set_option('margin-top', '0');
// $dompdf->set_option('margin-bottom', '0');
// $dompdf->set_option('margin-left', '0');
// $dompdf->set_option('margin-right', '0');
// $dompdf->render();
// $pdf_content = $dompdf->output();
// file_put_contents('ticket.pdf', $pdf_content);
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
    width: 50px;
  }
</style>
</head>
<body>
<div>
    <h1>Ticket</h1>
    <p>-------------------------------</p>
    <p>Fecha: 02/03/2023</p>
    <p>Hora: 14:15:10</p>
    <p>-------------------------------</p>
    <div class='detalle'>
      <p>Operacion:</p>
      <p>(compra)</p>
    </div>
    <div class='detalle'>
      <p class='moneda'> USD</p>
      <p class='operacion'>10000</p>
    </div>
    <div class='detalle'>
      <p>Cot</p>
      <p>1050</p>
    </div>
    <p>-------------------------------</p>
    <div class='detalle'>
      <p>Total:</p>
      <p>$10500000</p>
    </div>

</div>
</body>
</html>





<script src="js/escpos.js"></script>
<script src="js/ticket.js"></script>