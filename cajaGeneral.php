<?php 
    require "app/app.php";
    validarGerenteGeneral();
    if(!isset($_GET['fecha'])){
        $fecha = date("Y-m-d");
    }else{
        $fecha = $_GET['fecha'];
    }
    
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST["eliminarOperacion"])){
            $codigo = $_POST['codigo'];
            $idOperacion = $_POST['idOperacion'];
            $operacion = new Operaciones;
            $operacion->deleteOperacion($idOperacion,$codigo);
            header("location: ./cajaUsuario.php?fecha=$fecha");
        }
    }
    html("Caja");

    $usuario = new Usuarios;
    $usuario = $usuario->returnUsuario($_SESSION['idUsuario']);
     menu();
     

    
   echo $fecha;
?>
        
<section class="contCaja">
    <div class="topCaja">
        <div class="cajaTablaTop">
            <table class="tftable" border="1px">
                <tr><th>Tipo de Caja</th><td>CAJA GENERAL</td></tr>
                <tr><th>Dia</th><td><form action="" id="fechForm"><input type="date" name="fecha" onchangue="fechForm()" oninput="fechForm()" value="<?php echo $fecha ?>"></form></td></tr>
            </table>
            <table class="tftable" border="1px">
                <tr><th>Saldos</th><th>ARS <img src="img/arg.png" alt=""></th><th>USD <img src="img/usd.png" alt=""></th><th>EUR <img src="img/eur.png" alt=""></th></tr>
                <tr><th>Saldos Iniciales</th><td id="inStockPesos"></td><td id="inStockDolares"></td><td id="inStockEuros"></td></tr>
                
                <?php if( $fecha != date('Y-m-d')){ ?>
                <tr><th>Saldos Finales</th><td id="finStockPesos"></td><td id="finStockDolares"></td><td id="finStockEuros"></td></tr>
                <?php }?>
                <?php if( $fecha == date('Y-m-d')){ ?>
                <tr><th>Saldos Actuales</th><td id="stockPesos"></td><td id="stockDolares"></td><td id="stockEuros"></td></tr>
                <?php }?>
            </table>
            <table class="tftable" border="1px" style="max-width:max-content;">
                <tr><th>Accion</th></tr>
                <tr><td>
                <button type="button" onclick="mostrar3()"  class="btn">Simulador</button>
                </td></tr>
            </table>
        </div>
    </div>
    <div class="midBotCaja">
        <div class="contCajaMid" id="tablaCaja"></div> 
    </div> 
</section>



<!-- FUNCIONES TIEMPO REAL -->
<script type="text/javascript">
    function stock(){
        // STOCK INICIAL
        var instockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=1&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockPesos").innerHTML = instockPesos;
        var instockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=2&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockDolares").innerHTML = instockDolares;
        var instockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=3&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockEuros").innerHTML = instockEuros;
        // STOCK FINAL
        if(document.querySelector('#finStockPesos') !== null){
        var finstockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=1&tipo=Final&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockPesos").innerHTML = finstockPesos;
        var finstockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=2&tipo=Final&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        if(!!document.getElementById("finStockDolares")){
            document.getElementById("finStockDolares").innerHTML = finstockDolares;

        }
        var finstockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=3&tipo=Final&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockEuros").innerHTML = finstockEuros;
        }
        // STOCK ACTUAL
        if(document.querySelector('#stockPesos') !== null){   
        var stockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=1&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockPesos").innerHTML = stockPesos;
        var stockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=2&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockDolares").innerHTML = stockDolares;
        var stockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockGeneral.php?moneda=3&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockEuros").innerHTML = stockEuros;
        }
    }
    stock();
    setInterval(stock, 2000);
    function tablaCaja(){
        var tabla= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/tablaCajaGeneral.php?fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("tablaCaja").innerHTML = tabla;
    }
    tablaCaja();
    setInterval(tablaCaja, 2000);
    function fechForm(){
        document.getElementById('fechForm').submit();
    }

  </script>

<!-- FUNCION DE ELIMINAR PRODUCTO -->
<div class="fondoVentana" id="fondoVentana" onClick="">
    <div class="contVentana" >
        
        <form action="" method="POST">
                <input type="hidden" value="1" name="eliminarOperacion">
                <input type="hidden" value="0" name="idOperacion" id="idEliminar">
                <h3>Confirmar Eliminacion</h3>
                <p>Operacion <spa id="idMostrar">0</span></p>
                <input type="text" placeholder="CODIGO" name="codigo">
                <button type="submit" class="btnAceptar">Aceptar</button>
                <button type="button" class="btnCancelar" onClick="cerrar()" >Cancelar</button>
            
        </form>
    </div>
</div>
<script>
    const fondoVentana = document.getElementById("fondoVentana");

    function eliminar(id){
        console.log(id);
        mostrar();
        const inputId = document.getElementById('idEliminar');
        inputId.value = id;
        const span = document.getElementById('idMostrar');
        span.innerHTML = id;
    }
    function mostrar(){
        fondoVentana.style.display = "flex"
    }
    function cerrar(){
        fondoVentana.style.display = "none"
    }
</script>
<!-- FUNCION DE simulador  -->
<div class="fondoVentana" id="fondoVentana3" onClick="">
    <div class="contVentana" >
  
        <iframe id="ifrSimulador" src="modules/simuladorGeneral.php?fecha=<?php echo $fecha ?>" frameborder="0" class="iframeSimulador"></iframe>
        <button type="button" class="btnCancelar" onClick="cerrar3()" style="margin:0;" >Cerrar</button>
    </div>
</div>
<script>
    const fondoVentana3 = document.getElementById("fondoVentana3");


    function mostrar3(){
        fondoVentana3.style.display = "flex"
        var iframe = document.getElementById('ifrSimulador');
        iframe.src = iframe.src;
    }
    function cerrar3(){
        fondoVentana3.style.display = "none"
    }
</script>

