<?php 
  require "app/app.php";
  
  validarGerenteGeneral();
  html("Estadisticas");
  menu();
  $sucursal = 0;
  $dia = date("Y")."-".date("m")."-".date("d");
  $mes = date("Y")."-".date("m");
  $anio = date("Y");

  if(isset($_GET['dia'])){
    $dia = $_GET['dia'];
  }
  if(isset($_GET['mes'])){
    $mes = $_GET['mes'];
  }
  if(isset($_GET['anio'])){
    $anio = $_GET['anio'];
  }
  if(isset($_GET['sucursal'])){
    $sucursal = $_GET['sucursal'];
  }
  // ver($mes);


  ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="contenedor">
  <h1>Estadisticas</h1>
</div>
<div class="contenedor">
  <form action="" id="sucForm">
  <h3>SUCURSAL</h3>

  <select name="sucursal" id="selecSucursal" onchangue="sucForm()" oninput="sucForm()">
      <option value="0">General</option>
      <?php 
       $suc = new Sucursales;
       $suc = $suc->returnSucursales();

       foreach($suc as $s){
        $selec = "";
        if($s->idSucursal == $_GET['sucursal']){
          $selec = "selected";
        }?>
        <option <?php echo $selec; ?> value="<?php echo $s->idSucursal; ?>"><?php echo $s->nombre; ?></option>
      <?php } ?>
    </select>
    <input type="hidden" name="dia" value="<?php echo $dia ?>">
    <input type="hidden" name="mes" value="<?php echo $mes ?>">
    <input type="hidden" name="anio" value="<?php echo $anio ?>">
  </form>
</div>
<!-- 
cuanto se compró en el dia, 
cuanto se vendió en el día, 
spread promedio en el dia, 
ganancia en el día, 
-->
<div class="contenedor">
  <h3>Dia</h3>
  <form action="" id="fechDiaForm">
    <input type="hidden" name="sucursal" value="<?php echo $sucursal ?>">
    <input type="date" name="dia" onchangue="fechDiaForm()" oninput="fechDiaForm()" value="<?php echo $dia ?>">
    <input type="hidden" name="mes" value="<?php echo $mes ?>">
    <input type="hidden" name="anio" value="<?php echo $anio ?>">
  </form>
  <?php $operaciones = new Operaciones; ?>
  <table class="tftable" border="1px" style="overflow-x: hidden;">
    <tr><th>Moneda</th><th>Compra del dia</th><th>Venta del Dia</th><th>Spread Promedio Del Dia</th><th>Ganancia Bruta Del Dia</th><th>Ganancia / Perdida Stock de Pesos Del Dia</th><th>Ganancia Bruta Del Dia</th></tr>
    <tr><th>USD <img src="img/usd.png" alt=""></th><td><?php echo $operaciones->compraDelDia($sucursal,$dia,2); ?></td><td><?php echo $operaciones->ventaDelDia($sucursal,$dia,2); ?></td><td><?php echo $operaciones->spreadDelDia($sucursal,$dia,2); ?></td><td><?php echo $operaciones->gananciaBrutaDelDia($sucursal,$dia,2); ?></td><td><?php echo $operaciones->diferenciaDeStockDelDia($sucursal,$dia,2); ?></td><td><?php echo $operaciones->gananciaNetaDelDia($sucursal,$dia,2); ?></td></tr>
    <tr><th>EUR <img src="img/eur.png" alt=""></th><td><?php echo $operaciones->compraDelDia($sucursal,$dia,3); ?></td><td><?php echo $operaciones->ventaDelDia($sucursal,$dia,3); ?></td><td><?php echo $operaciones->spreadDelDia($sucursal,$dia,3); ?></td><td><?php echo $operaciones->gananciaBrutaDelDia($sucursal,$dia,3); ?></td><td><?php echo $operaciones->diferenciaDeStockDelDia($sucursal,$dia,3); ?></td><td><?php echo $operaciones->gananciaNetaDelDia($sucursal,$dia,3); ?></td></tr>
  </table>
</div>
<?php

    $cons = conectarDB("SELECT
    fecha,
    COUNT(*) AS total_operaciones,
    SUM(monto) AS total_monto,
    SUM(cotizacion * monto) / SUM(monto) AS cotizacion_promedio_ponderado
    FROM
        operaciones
    GROUP BY
        fecha
    ORDER BY
    fecha");
    foreach($cons as $c){
      ver($c);
    }
    // ver(mysqli_fetch_assoc($cons));

?>
 <!-- 
cuanto se compro en el mes,
cuanto se vendio en el mes,
spread promedio en el mes,
ganancia en el mes, 
 -->
<div class="contenedor">
  <h3>Mes</h3>
  <form action="" id="fechMesForm">
    <input type="hidden" name="sucursal" value="<?php echo $sucursal ?>">
    <input type="hidden" name="dia" value="<?php echo $dia ?>">
    <input type="month" name="mes" onchangue="fechMesForm()" oninput="fechMesForm()" value="<?php echo $mes ?>">
    <input type="hidden" name="anio" value="<?php echo $anio ?>">
  </form>
  <table class="tftable" border="1px" style="overflow-x: hidden;">
    <tr><th>Moneda</th><th>Compra del Mes</th><th>Venta del Mes</th><th>Spread Promedio Del Mes</th><th>Ganancia Bruta Del Mes</th></tr>
    <tr><th>USD <img src="img/usd.png" alt=""></th><td><?php echo $operaciones->compraDelMes($sucursal,$mes,2); ?></td><td><?php echo $operaciones->ventaDelMes($sucursal,$mes,2); ?></td><td><?php echo $operaciones->spreadDelMes($sucursal,$mes,2); ?></td><td><?php echo $operaciones->gananciaBrutaDelMes($sucursal,$mes,2); ?></td></tr>
    <tr><th>EUR <img src="img/eur.png" alt=""></th><td><?php echo $operaciones->compraDelMes($sucursal,$mes,3); ?></td><td><?php echo $operaciones->ventaDelMes($sucursal,$mes,3); ?></td><td><?php echo $operaciones->spreadDelMes($sucursal,$mes,3); ?></td><td><?php echo $operaciones->gananciaBrutaDelMes($sucursal,$mes,3); ?></td></tr>
  </table>
</div>
<div class="contenedor">
    <canvas id="graficoComprasVentasMes"></canvas>
</div>
<!-- 
cuanto se compro en el año,
cuanto se vendio en el año,
spread promedio en el año,
ganancia en el año, 
-->
<div class="contenedor">
  <h3>Año</h3>
  <form action="" id="fechAnioForm">
    <input type="hidden" name="sucursal" value="<?php echo $sucursal ?>">
    <input type="hidden" name="dia" value="<?php echo $dia ?>">
    <input type="hidden" name="mes" value="<?php echo $mes ?>">
    <!-- <input type="date" name="dia" onchangue="fechDiaForm()" oninput="fechDiaForm()" value="<?php echo $dia ?>"> -->
    <select name="anio" onchangue="fechAnioForm()" oninput="fechAnioForm()" value="<?php echo $anio ?>">
      <option value="2023">2023</option>
      <?php
        for($i=0;$i<(date("Y")-2023);$i++){
          $an = 2023 + 1 + $i;
          echo "<option value='".$an."'>".$an."</option>";
        }
      ?>
      
      
    </select>
  </form>

  <table class="tftable" border="1px" style="overflow-x: hidden;">
    <tr><th>Moneda</th><th>Compra del Año</th><th>Venta del Año</th><th>Spread Promedio Del Año</th><th>Ganancia Del Año</th></tr>
    <tr><th>USD <img src="img/usd.png" alt=""></th><td><?php echo $operaciones->compraDelAnio($sucursal,$anio,2); ?></td><td><?php echo $operaciones->ventaDelAnio($sucursal,$anio,2); ?></td><td><?php echo $operaciones->spreadDelAnio($sucursal,$anio,2); ?></td><td><?php echo $operaciones->gananciaBrutaDelAnio($sucursal,$anio,2); ?></td></tr>
    <tr><th>EUR <img src="img/eur.png" alt=""></th><td><?php echo $operaciones->compraDelAnio($sucursal,$anio,3); ?></td><td><?php echo $operaciones->ventaDelAnio($sucursal,$anio,3); ?></td><td><?php echo $operaciones->spreadDelAnio($sucursal,$anio,3); ?></td><td><?php echo $operaciones->gananciaBrutaDelAnio($sucursal,$anio,3); ?></td></tr>
  </table>
</div>
<div class="contenedor">
    <canvas id="graficoComprasVentasAnio"></canvas>
</div>
<!-- 
que días de la semana se compra más, 
que días de la semana se vende más, 
que días del mes se compra más, 
que días del mes se vende más, 
 -->
<div class="contenedor">
  
  <div class="contFlex2">
      <div>
        <table class="tftable" border="1px" style="overflow-x: hidden;">
          <tr><th>Dia del mes Que mas Se compra Dolares <img src="img/usd.png" alt=""></th><td><?php echo $operaciones->diaDelMesQueMasSeCompra($sucursal, $mes,2 ) ?></td></tr>
          <tr><th>Dia del mes Que mas Se Vende Dolares <img src="img/usd.png" alt=""></th><td><?php echo $operaciones->diaDelMesQueMasSeVende($sucursal, $mes,2 ) ?></td></tr>
          <tr><th>Dia de la semana Que mas Se compra Dolares <img src="img/usd.png" alt=""></th><td><?php echo $operaciones->diaDeLaSemanaQueMasSeCompra($sucursal,2); ?></td></tr>
          <tr><th>Dia de la semana Que mas Se Vende Dolares <img src="img/usd.png" alt=""></th><td><?php echo $operaciones->diaDeLaSemanaQueMasSeVende($sucursal,2); ?></td></tr>
        </table>
      </div>
      <div>
        <table class="tftable" border="1px" style="overflow-x: hidden;">
          <tr><th>Dia del mes Que mas Se compra Euros <img src="img/eur.png" alt=""></th><td><?php echo $operaciones->diaDelMesQueMasSeCompra($sucursal, $mes,3 ) ?></td></tr>
          <tr><th>Dia del mes Que mas Se Vende Euros <img src="img/eur.png" alt=""></th><td><?php echo $operaciones->diaDelMesQueMasSeVende($sucursal, $mes,3 ) ?></td></tr>
          <tr><th>Dia de la semana Que mas Se compra Euros <img src="img/eur.png" alt=""></th><td><?php echo $operaciones->diaDeLaSemanaQueMasSeCompra($sucursal,3); ?></td></tr>
          <tr><th>Dia de la semana Que mas Se Vende Euros <img src="img/eur.png" alt=""></th><td><?php echo $operaciones->diaDeLaSemanaQueMasSeVende($sucursal,3); ?></td></tr>
        </table>
      </div>
  </div>

</div>


<script>
  function fechDiaForm(){
    document.getElementById('fechDiaForm').submit();
  }
  function fechMesForm(){
    document.getElementById('fechMesForm').submit();
  }
  function fechAnioForm(){
    document.getElementById('fechAnioForm').submit();
  }
  function sucForm(){
    document.getElementById('sucForm').submit();
  }
</script>
<?php
llenarArrayConNumeros(obtenerDiasEnMes($mes))
?>
<script>
    // Obtener el elemento canvas
    var ctx1 = document.getElementById('graficoComprasVentasAnio').getContext('2d');
    var ctx2 = document.getElementById('graficoComprasVentasMes').getContext('2d');
    // Crear un conjunto de datos
    var data1 = {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
            label: 'Compras Dolares '+<?php echo $anio ?>,
            data: <?php echo json_encode($operaciones->comprasVentasDelAnio($sucursal,$anio,2,1)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(52, 152, 219, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(52, 152, 219, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        },{
            label: 'Ventas Dolares '+<?php echo $anio ?>,
            data: <?php echo json_encode($operaciones->comprasVentasDelAnio($sucursal,$anio,2,2)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(52, 152, 50, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(52, 152, 50, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        },{
            label: 'Compras Euros '+<?php echo $anio ?>,
            data: <?php echo json_encode($operaciones->comprasVentasDelAnio($sucursal,$anio,3,1)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(152, 152, 50, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(152, 152, 50, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        },{
            label: 'Ventas Euros '+<?php echo $anio ?>,
            data: <?php echo json_encode($operaciones->comprasVentasDelAnio($sucursal,$anio,3,2)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(252, 52, 50, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(252, 52, 50, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        }]
    };
    var data2 = {
        labels: <?php echo json_encode(llenarArrayConNumeros(obtenerDiasEnMes($mes))) ?>,
        datasets: [{
            label: 'Compras Dolares <?php echo $mes."" ?>',
            data: <?php echo json_encode($operaciones->comprasVentasDelMes($sucursal,$mes,2,1)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(52, 152, 219, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(52, 152, 219, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        },{
            label: 'Ventas Dolares <?php echo $mes ?>',
            data: <?php echo json_encode($operaciones->comprasVentasDelMes($sucursal,$mes,2,2)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(52, 152, 50, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(52, 152, 50, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        },{
            label: 'Compras Euros <?php echo $mes ?>',
            data: <?php echo json_encode($operaciones->comprasVentasDelMes($sucursal,$mes,3,1)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(152, 152, 50, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(152, 152, 50, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        },{
            label: 'Ventas Euros <?php echo $mes ?>',
            data: <?php echo json_encode($operaciones->comprasVentasDelMes($sucursal,$mes,3,2)); ?>, // Los valores de tus datos
            backgroundColor: 'rgba(252, 52, 50, 0.5)', // Color de fondo de las barras
            borderColor: 'rgba(252, 52, 50, 1)', // Color del borde de las barras
            borderWidth: 2.5 // Ancho del borde de las barras
        }]
    };
    // Configurar opciones del gráfico
    var options = {
        scales: {
            y: {
                beginAtZero: true // Iniciar eje y desde 0
            }
        }
    };

    // Crear un gráfico de barras
    var graficoComprasVentasAnio = new Chart(ctx1, {
        type: 'bar', // Tipo de gráfico
        data: data1, // Datos
        options: options // Opciones
    });
    var graficoComprasVentasMes = new Chart(ctx2, {
        type: 'bar', // Tipo de gráfico
        data: data2, // Datos
        options: options // Opciones
    });
</script>