<?php 
    require "app/app.php";
    validarGerenteOEncargado();
    if(!isset($_GET['fecha'])){
        $fecha = date("Y-m-d");
    }else{
        $fecha = $_GET['fecha'];
    }
    if(!isset($_GET['sucursal'])){
      $sucursal = $_SESSION['idSucursal'];
      
    }else{
        $sucursal = $_GET['sucursal'];
    }
    if(!isset($_GET['pag'])){
      $pag = 1;
    }else{
        $pag = $_GET['pag'];
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
     

    
   
?>
        
<section class="contCaja">
    <div class="topCaja">
        <div class="cajaTablaTop">
            <table class="tftable" border="1px">
            <form action="" id="fechForm">
                <tr><th>Tipo de Caja</th><td>CAJA SUCURSAL</td></tr>
                <tr><th>Dia</th><td><input type="date" name="fecha" onchangue="fechForm()" oninput="fechForm()" value="<?php echo $fecha ?>"></td></tr>
                <tr><th>Sucursal</th><td>
                  <select name="sucursal" onchangue="fechForm()" oninput="fechForm()">
                    <?php 
                      
                      if($_SESSION['rol']==2){
                        $suc = new Sucursales;
                        $suc = $suc->returnSucursales();
                      
                      
                      
                      foreach($suc as $s){
                        $selec = "";
                        if($s->idSucursal == $_GET['sucursal']){
                          $selec = "selected";
                        }
                    ?>
                      <option <?php echo $selec; ?> value="<?php echo $s->idSucursal; ?>"><?php echo $s->nombre; ?></option>
                    <?php }}else{
                        $suc = new Sucursales;
                        $s = $suc->returnSucursal($_SESSION['idSucursal']);
                        
                        $selec = "selected";
                        ?>
                          <option <?php echo $selec; ?> value="<?php echo $s->idSucursal; ?>"><?php echo $s->nombre; ?></option>

                    <?php } ?>
                  </select>
                </td></tr>
                <input type="hidden" name="pag" value="1">

                </form>
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
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=1&sucursal=<?php echo $sucursal ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockPesos").innerHTML = instockPesos;
        var instockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=2&sucursal=<?php echo $sucursal ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockDolares").innerHTML = instockDolares;
        var instockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=3&sucursal=<?php echo $sucursal ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockEuros").innerHTML = instockEuros;
        // STOCK FINAL
        if(document.querySelector('#finStockPesos') !== null){
        var finstockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=1&sucursal=<?php echo $sucursal ?>&tipo=Final&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockPesos").innerHTML = finstockPesos;
        var finstockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=2&sucursal=<?php echo $sucursal ?>&tipo=Final&fecha=<?php echo $fecha ?>s',
            dataType: 'text',
            async: false,
        }).responseText;
        if(!!document.getElementById("finStockDolares")){
            document.getElementById("finStockDolares").innerHTML = finstockDolares;

        }
        var finstockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=3&sucursal=<?php echo $sucursal ?>&tipo=Final&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockEuros").innerHTML = finstockEuros;
        }
        // STOCK ACTUAL
        if(document.querySelector('#stockPesos') !== null){   
        var stockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=1&sucursal=<?php echo $sucursal ?>&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockPesos").innerHTML = stockPesos;
        var stockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=2&sucursal=<?php echo $sucursal ?>&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockDolares").innerHTML = stockDolares;
        var stockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stockSucursal.php?moneda=3&sucursal=<?php echo $sucursal ?>&tipo=Actual&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockEuros").innerHTML = stockEuros;
        }
    }
    stock();
    setInterval(stock, 10000);
    function tablaCaja(){
        var tabla= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/tablaCajaSucursal.php?fecha=<?php echo $fecha ?>&sucursal=<?php echo $sucursal ?>&pag=<?php echo $pag ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("tablaCaja").innerHTML = tabla;
    }
    tablaCaja();
    setInterval(tablaCaja, 10000);
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
