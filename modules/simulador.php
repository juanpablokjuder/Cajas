<?php
  require "../app/app.php";

  $fecha = $_GET['fecha'];
  $idUsuario = $_GET['idUsuario'];

  html("simulador");
?>
 <style>
   body{
     width: 100vw;
     margin-left: 0;
     background-color: #fff;
   }
 </style>
 <section class="contSimulador">
    <div class="topSimulador">
      <h1 class="tituloSimulador">Simulador</h1>
    </div>
    <div class="contSaldosSimulador">
      <div>
        <h2>Saldos Actuales</h2>
        <div>
          <h3><img src="../img/arg.png" alt=""> Saldo Pesos: $ <span id="spnInArg"></span></h3>
          <h3><img src="../img/usd.png" alt=""> Saldo Dolares: U$D <span id="spnInUsd"></span></h3>
          <h3><img src="../img/eur.png" alt=""> Saldo Euros: € <span id="spnInEur"></span></h3>
        </div>
      </div>
     
      <div>
        <h2>Saldos Futuros</h2>
        <div>
          <h3><img src="../img/arg.png" alt=""> Saldo Pesos: $ <span id="spnFinArg">100</span></h3>
          <h3><img src="../img/usd.png" alt=""> Saldo Dolares: U$D <span id="spnFinUsd">100</span></h3>
          <h3><img src="../img/eur.png" alt=""> Saldo Euros: € <span id="spnFinEur">100</span></h3>
        </div>
      </div>
    </div>
    <div id="tablaCaja2"> </div>
    <div>

    </div>
 </section>
<script>
  function GuardarOperacion(){
    var slcOp =  document.getElementById("slcOperacion")
    var op = slcOp.options[slcOp.selectedIndex].text
    var usd = document.getElementById("inUSD").value
    var eur = document.getElementById("inEUR").value
    var cot = document.getElementById("inCOT").value
    var ars = 0
    if (usd != ""){
      ars = usd * cot 
    }else { ars = eur * cot}
    addRow(op,usd,eur,cot,ars)
  }
  function addRow(op,usd,eur,cot,ars){
    var tabla = document.getElementById("tblSimulador");
    // Crea una nueva fila
    var fila = tabla.insertRow(2);

    // Inserta celdas en la nueva fila
    var celda1 = fila.insertCell(0);
    var celda2 = fila.insertCell(1);
    var celda3 = fila.insertCell(2);
    var celda4 = fila.insertCell(3);
    var celda5 = fila.insertCell(4);
    var celda6 = fila.insertCell(5);
    var celda7 = fila.insertCell(6);
    var celda8 = fila.insertCell(7);
    // datos

    celda1.innerHTML = op;
    celda2.innerHTML = "U$D " + usd;
    celda3.innerHTML = "€ " + eur;
    celda4.innerHTML = cot;
    celda5.innerHTML = "$ "+ ars;
    celda6.innerHTML = "-";
    celda7.innerHTML = "-";
    celda8.innerHTML = "SIMULACION";

  }
  function tablaCaja2(){
      var tabla= $.ajax ({
          url: '<?php echo $GLOBALS['pathInicio'] ?>modules/tablaSimulador.php?user=<?php echo $idUsuario ?>&fecha=<?php echo $fecha ?>',
          dataType: 'text',
          async: false,
      }).responseText;
      document.getElementById("tablaCaja2").innerHTML = tabla;
  }
  tablaCaja2();
    
</script>