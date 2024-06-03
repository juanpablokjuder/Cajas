<?php
  require "../app/app.php";

  $fecha = $_GET['fecha'];


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
          <h3><img src="../img/arg.png" alt=""> Saldo Pesos:  <span id="spnInArg"></span></h3>
          <h3><img src="../img/usd.png" alt=""> Saldo Dolares: <span id="spnInUsd"></span></h3>
          <h3><img src="../img/eur.png" alt=""> Saldo Euros:  <span id="spnInEur"></span></h3>
        </div>
      </div>
     
      <div>
        <h2>Saldos Futuros</h2>
        <div>
          <h3><img src="../img/arg.png" alt=""> Saldo Pesos: <span id="spnFinArg">100</span></h3>
          <h3><img src="../img/usd.png" alt=""> Saldo Dolares: <span id="spnFinUsd">100</span></h3>
          <h3><img src="../img/eur.png" alt=""> Saldo Euros: <span id="spnFinEur">100</span></h3>
        </div>
      </div>
    </div>
    <div id="tablaCaja2"> </div>
    <div>

    </div>
 </section>
<script> 
  function formatoInput(input){
    console.log(input.value.length)
    if(input.value.length > 0){
      if (input.id == "inUSD"){
        document.getElementById("inEUR").disabled = true;
      
      }else{
        document.getElementById("inUSD").disabled = true;

      }
    }else{
      document.getElementById("inUSD").disabled = false;
      document.getElementById("inEUR").disabled = false;

    }
    // Remover caracteres no numéricos
    input.value = input.value.replace(/[^\d]/g, '');

  }
  function GuardarOperacion(){
   
    var slcOp =  document.getElementById("slcOperacion")
    var op = slcOp.options[slcOp.selectedIndex].text
    var usd = document.getElementById("inUSD").value
    var eur = document.getElementById("inEUR").value
    var cot = document.getElementById("inCOT").value
    if( (usd == "" && eur == "") || cot == "") return
    var ars = 0
    if (usd != ""){
      ars = usd * cot 
      eur = 0
    }else { ars = eur * cot; usd = 0}
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
    var celda9 = fila.insertCell(8);
    var celda10 = fila.insertCell(9);
    // Agrega clases
    if (op == "Compra") {
        if (usd > 0) {
            celda2.classList.add("cVerde");
            celda3.classList.add("cGris");
            celda5.classList.add("cRojo");
            ars = ars * -1
        }
        if (eur > 0) {
            celda3.classList.add("cVerde");
            celda2.classList.add("cGris");
            celda5.classList.add("cRojo");
            ars = ars * -1
        }
    }else{
      if (usd > 0) {
            celda2.classList.add("cRojo");
            celda3.classList.add("cGris");
            celda5.classList.add("cVerde");
            usd = usd * -1
      }
      if (eur > 0) {
          celda3.classList.add("cRojo");
          celda2.classList.add("cGris");
          celda5.classList.add("cVerde");
          eur = eur * -1
      }
    }
    // datos

    celda1.innerHTML = op;
    celda2.innerHTML = "U$D " + usd.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });;
    celda3.innerHTML = "€ " + eur.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });;
    celda4.innerHTML = cot;
    celda5.innerHTML = "$ "+ ars.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });;
    celda6.innerHTML = "-";
    celda7.innerHTML = "-";
    celda8.innerHTML = "-";
    celda9.innerHTML = "-";
    celda10.innerHTML = "SIMULACION";
    UpdateStock(usd, eur, ars);
    document.getElementById("inUSD").value = ""
    document.getElementById("inEUR").value = ""
     document.getElementById("inCOT").value = ""
     document.getElementById("inUSD").disabled = false;
      document.getElementById("inEUR").disabled = false;

  }
  function UpdateStock(usd, eur, ars){
    var sArs = parseFloat(document.getElementById('spnFinArg').innerText.replace("$","").replace(/\./g, "").replace(",", "."))
    var sUsd = parseFloat(document.getElementById('spnFinUsd').innerText.replace("U","").replace("$","").replace("D","").replace(/\./g, "").replace(",", "."))
    var sEur = parseFloat(document.getElementById('spnFinEur').innerText.replace("€","").replace(/\./g, "").replace(",", "."))
    console.log(sArs);
    console.log(sUsd);
    console.log(sEur);
    sArs = parseFloat(ars) + sArs 
    sUsd = parseFloat(usd) + sUsd 
    sEur = parseFloat(eur) + sEur

    sArs = sArs.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    sUsd = sUsd.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    sEur = sEur.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    document.getElementById('spnFinArg').textContent = "$ " + sArs
    document.getElementById('spnFinUsd').textContent = "U$D " + sUsd
    document.getElementById('spnFinEur').textContent = "€ " + sEur
  }
  function tablaCaja2(){
      var tabla= $.ajax ({
          url: '<?php echo $GLOBALS['pathInicio'] ?>modules/tablaSimuladorGeneral.php?fecha=<?php echo $fecha ?>',
          dataType: 'text',
          async: false,
      }).responseText;
      document.getElementById("tablaCaja2").innerHTML = tabla;
  }
  tablaCaja2();
  function saldo(){
      // STOCK ACTUAL
      
        var stockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=1&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("spnInArg").innerHTML = stockPesos;
        document.getElementById("spnFinArg").innerHTML = stockPesos;
        var stockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=2&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("spnInUsd").innerHTML = stockDolares;
        document.getElementById("spnFinUsd").innerHTML = stockDolares;
        var stockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=1&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("spnInEur").innerHTML = stockEuros;
        document.getElementById("spnFinEur").innerHTML = stockEuros;
        
  }
  saldo()
</script>