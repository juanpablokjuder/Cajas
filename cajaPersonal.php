<?php 
    require "app/app.php";
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
            header("location: ./cajaPersonal.php?fecha=$fecha");
        }
        if(isset($_POST["nuevaOperacion"])){
            $op = new Operacion;
            $op->idUsuario = $_SESSION['idUsuario'];
            $op->tipoOperacion = $_POST["TipoOperacion"];
            $op->idMoneda = $_POST["Monedas"];
            $op->monto = $_POST["monto"];
            if($_POST["TipoOperacion"]==4){
                $op->monto = $op->monto *-1;
            }
            $op->cotizacion = $_POST["cotizacion"];
            $detalle = "";
            if($_POST["TipoOperacion"] == 4){
                $usuario = new Usuarios;
                $usuario = $usuario->returnUsuario($_SESSION['idUsuario']);
                $usuario2 = new Usuarios;
                $usuario2 = $usuario2->returnUsuario($_POST['Usuario']);
                if($usuario->idSucursal == $usuario2->idSucursal){
                    $detalle = "EGRESO A ".$usuario2->nombre;
                }else{
                    $sucursal = new Sucursales();
                    $sucursal = $sucursal->returnSucursal($usuario2->idSucursal);
                    $detalle = "EGRESO A ".$usuario2->nombre." DE ".$sucursal->nombre;
                }
            }else{
                $detalle = $_POST["detalle"];
            }
            $op->detalle = $detalle;
            $operacion = new Operaciones;
            
            if($operacion->insertOperacion($op)){
                if($op->tipoOperacion == 1 || $op->tipoOperacion == 2){
                    //   IMPRIMIR TICKET TICKET
                    $fecha_actual = new DateTime();

                    $fechaa = $fecha_actual->format('d/m/Y');
                    $hora = $fecha_actual->format('H:i:s');
                    $operacion = $op->tipoOperacion == 1 ? "compra" :  "venta";
                    $moneda = $op->idMoneda == 2 ? "USD" : "EUR";
                    $monto = $op->monto;
                    $cot = $op->cotizacion;
                    $total = $op->cotizacion * $op->monto;
                    $_SESSION['urlImprimir'] = "ticket.php?fecha=".$fechaa."&hora=".$hora."&operacion=".$operacion."&moneda=".$moneda."&monto=".$monto."&cot=".$cot."&total=".$total;
                    
                }
                if($op->tipoOperacion == 4){
                    $op2 = new Operacion;
                    $op2->idUsuario = $_POST['Usuario'];
                    $op2->tipoOperacion = 3;
                    $op2->idMoneda = $_POST["Monedas"];
                    $op2->monto = $_POST["monto"];
                    $usuario = new Usuarios;
                    $usuario = $usuario->returnUsuario($_SESSION['idUsuario']);
                    $usuario2 = new Usuarios;
                    $usuario2 = $usuario2->returnUsuario($op2->idUsuario);
                    if($usuario->idSucursal == $usuario2->idSucursal){
                        $detalle = "INGRESO DE ".$usuario->nombre;
                    }else{
                        $sucursal = new Sucursales();
                        $sucursal = $sucursal->returnSucursal($usuario->idSucursal);
                        $detalle = "INGRESO DE ".$usuario->nombre." DE ".$sucursal->nombre;
                    }
                    $op2->detalle = $detalle;
                    $operacion = new Operaciones;
                    $operacion->insertOperacion($op2);
                }
                 
            }
            header("location: ./cajaPersonal.php?fecha=$fecha");
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
                <tr><th>Tipo de Caja</th><td>CAJA PERSONAL</td></tr>
                <tr><th>Dia</th><td><form action="" id="fechForm"><input type="date" name="fecha" onchangue="fechForm()" oninput="fechForm()" value="<?php echo $fecha ?>"></form></td></tr>
                <tr><th>Usuario</th><td><?php echo $usuario->nombre; ?></td></tr>
            </table>
            <table class="tftable saldos" border="1px">
                <tr><th>Saldos</th><th>ARS <img src="img/arg.png" alt=""></th><th>USD <img src="img/usd.png" alt=""></th><th>EUR <img src="img/eur.png" alt=""></th></tr>
                <tr><th>Saldos Iniciales</th><td id="inStockPesos"></td><td id="inStockDolares"></td><td id="inStockEuros"></td></tr>
                
                <?php if( $fecha != date('Y-m-d')){ ?>
                <tr><th>Saldos Finales</th><td id="finStockPesos"></td><td id="finStockDolares"></td><td id="finStockEuros"></td></tr>
                <?php }?>
                <?php if( $fecha == date('Y-m-d')){ ?>
                <tr><th>Saldos Actuales</th><td id="stockPesos"></td><td id="stockDolares"></td><td id="stockEuros"></td></tr>
                <?php }?>
            </table>
            <table class="tftable tablaCotCaja" border="1px" >
                
                <tr><th>Cot Act</th><th>USD <img src="img/usd.png" alt=""></th><th>EUR <img src="img/eur.png" alt=""></th</tr>
                <tr><th>Compra</th><td id="cDolar">0</td><td id="cEuro">0</td></tr>
                <tr><th>Venta</th><td id="vDolar">0</td><td id="vEuro">0</td></tr>
            </table> 
        </div>

    </div>

    <div class="midCaja">
    <?php 
            //MOSTRAR COSAS

        ?>
        <div class="contCajaMid" id="tablaCaja">
       
        </div> 
    </div>

    <div class="botCaja">
        <div>
            <h2 class="h2Operacion">Nueva Operacion</h2>
        </div>
        <form class="formContOperacion" method="POST">
            <input type="hidden" name="nuevaOperacion" value="1">
            <table class="tftable" border="1px" style="overflow-x: hidden;">
                <tr>
                    <th>Tipo de Operacion</th>
                    <th>Moneda</th>
                    <th>Cantidad</th>
                    <th id="thCotizacion">Cotizacion</th>
                    <th id="thUsuario" style="display:none;">Usuario</th>
                    <th id="thDetalle" style="display:none;">Detalle</th>
                </tr>
                <tr>
                    <td style="width: 200px">
                        <select name="TipoOperacion" id="selectOperacion" onchange="changeSelect()" class="inputCaja">
                            <option value=""></option>
                            <option value="1">Comprar</option>
                            <option value="2">Vender</option>
                            <option value="4">Transferir</option>
                            <?php if($_SESSION['rol']>0){ ?>
                                
                                <option value="5">Personalizado</option>
                            <?php } ?>
                            
                        </select>
                    </td>
                    <td>
                        <select name="Monedas" id="selectMoneda" onchange="changeSelect2()" class="inputCaja" disabled style="width: 150px;">
                            
                        </select>
                    </td>
                    <td>
                        <input type="number" name="monto" id="inputCantidad" class="inputCaja" oninput="recordatorioOp()" style="width: 150px;">
                    </td>
                    <td id="tdCotizacion">
                        <input type="text" name="cotizacion" id="inputCotizacion" class="inputCaja2" readonly style="width: 100px;">
                        <button type="button" class="inputCaja2 btn" onClick="mostrar2()" style="width: 100px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                            <path d="M16 5l3 3" />
                            </svg>
                        </button>
                    </td>
                    <td id="tdResultado">
                        <p><span id="recordatorio"></span></p>
                    </td>
                    <td id="tdUsuario" style="display:none;">
                        <select name="Usuario" id="selectUsuario" class="inputCaja" >
                            <?php if($_SESSION['rol']==0){
                                $usuario = new Usuarios();
                                $usuario = $usuario->returnGerentesSucursal($_SESSION['idSucursal'],$_SESSION['idUsuario']);
                                foreach($usuario as $user){
                                ?>
                                <option value="<?php echo $user->idUsuario ?>"><?php echo $user->nombre ?></option>
                            <?php }} ?>
                            <?php if($_SESSION['rol']>0){
                                $usuario = new Usuarios();
                                $usuario = $usuario->returnUsuarioSucursalYGerentes($_SESSION['idSucursal'],$_SESSION['idUsuario']);
                                foreach($usuario as $user){
                                    $sucursal = new Sucursales();
                                    $sucursal = $sucursal->returnSucursal($user->idSucursal);
                                ?>
                                <option value="<?php echo $user->idUsuario ?>"><?php echo $user->nombre." - ". $sucursal->nombre ?></option>
                            <?php }} ?>
                            
                           
                        </select>
                    </td>
                    <td id="tdDetalle" style="display:none;">
                        <input type="text" name="detalle" id="inputDetalle" class="inputCaja">
                    </td>
                    <td>
                        <input type="submit" value="Guardar" class="inputCaja btn">
                    </td>
                    <td>
                        <button type="button" onclick="print()" class="inputCaja btn">Imprimir</button>
                    </td>

                </tr>
                
            </table>
        </form>
        <div>
            <!-- <span id="recordatorio"></span> -->
        </div>
    </div>
</section>
<!-- FUNCIONES NUEVA OPERACION -->
<script type="text/javascript"> 
    function formatearNumeroConPuntos(numero) {
        return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    function changeSelect2(){
        const select = document.getElementById("selectOperacion");
        const select2 = document.getElementById("selectMoneda");
        var selectedOption = select.options[select.selectedIndex];
        var selectedValue = selectedOption.value;
        var selectedOption2 = select2.options[select2.selectedIndex];
        var selectedValue2 = selectedOption2.value;
        if(selectedValue == 1 || selectedValue == 2){
            if(selectedValue2 == 2){
                getCotizacion(2,selectedValue)
            }
            if(selectedValue2 == 3){
                getCotizacion(3,selectedValue)
            }
            recordatorioOp()
        }
        

    }
    function changeSelect(){
        const select = document.getElementById("selectOperacion");
        const select2 = document.getElementById("selectMoneda");
        const cotizacion = document.getElementById("inputCotizacion");
        
        const thCotizacion = document.getElementById("thCotizacion");
        const thDetalle = document.getElementById("thDetalle");
        const thUsuario = document.getElementById("thUsuario");

        const tdCotizacion = document.getElementById("tdCotizacion");
        const tdDetalle = document.getElementById("tdDetalle");
        const tdUsuario = document.getElementById("tdUsuario");
        const tdResultado = document.getElementById("tdResultado");

        var selectedOption = select.options[select.selectedIndex];
        var selectedValue = selectedOption.value;
        select2.disabled = false;
        cotizacion.value = "";
        vaciarSelect();
        agregarSelect("","");
        if(selectedValue == 1 || selectedValue == 2){
            // Crear un nuevo elemento option
            agregarSelect("Dolares",2);
            agregarSelect("Euros",3);
           thCotizacion.style.display = "";
           tdResultado.style.display = ""
           thUsuario.style.display = "none";
           thDetalle.style.display = "none";
           tdCotizacion.style.display = "";
           tdUsuario.style.display = "none";
           tdDetalle.style.display = "none";
           
        }
        if(selectedValue == 3 || selectedValue == 4 || selectedValue == 5){
            agregarSelect("Pesos",1)
            agregarSelect("Dolares",2);
            agregarSelect("Euros",3);
            if(selectedValue == 3 || selectedValue == 4){
                thCotizacion.style.display = "none";
                thUsuario.style.display = "";
                thDetalle.style.display = "none";
                tdCotizacion.style.display = "none";
                tdUsuario.style.display = "";
                tdDetalle.style.display = "none";
            }
            if(selectedValue == 5){
                thCotizacion.style.display = "none";
                thUsuario.style.display = "none";
                thDetalle.style.display = "";
                tdCotizacion.style.display = "none";
                tdUsuario.style.display = "none";
                tdDetalle.style.display = "";
            }
            tdResultado.style.display = "none";
        }
        const span = document.getElementById("recordatorio");
        
        span.textContent = " ";
    }
    function agregarSelect(moneda,value){
        const select = document.getElementById("selectMoneda");
        var nuevaOpcion = document.createElement("option");
        nuevaOpcion.value = value;
        nuevaOpcion.text = moneda;
        select.appendChild(nuevaOpcion);
    }
    function vaciarSelect(){
        const select = document.getElementById("selectMoneda");
        while (select.options.length > 0) {
            select.remove(0);
        }
    }
    
    
</script>
<!-- FUNCIONES TIEMPO REAL -->
<script type="text/javascript">
    function stock(){
        // STOCK INICIAL
        var instockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=1&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockPesos").innerHTML = instockPesos;
        var instockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=2&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockDolares").innerHTML = instockDolares;
        var instockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=3&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockEuros").innerHTML = instockEuros;
        // STOCK FINAL
        if(document.querySelector('#finStockPesos') !== null){
        var finstockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=1&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Final&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockPesos").innerHTML = finstockPesos;
        var finstockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=2&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Final&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        if(!!document.getElementById("finStockDolares")){
            document.getElementById("finStockDolares").innerHTML = finstockDolares;

        }
        var finstockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=3&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Final&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockEuros").innerHTML = finstockEuros;
        }
        // STOCK ACTUAL
        if(document.querySelector('#stockPesos') !== null){
        var stockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=1&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Actual&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockPesos").innerHTML = stockPesos;
        var stockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=2&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Actual&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockDolares").innerHTML = stockDolares;
        var stockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=3&user=<?php echo $_SESSION['idUsuario'] ?>&tipo=Actual&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockEuros").innerHTML = stockEuros;
        }
    }
    stock();
    setInterval(stock, 3000);
    function getCotizacion(moneda,operacion){
        var moneda= $.ajax ({
            url: "<?php echo $GLOBALS['pathInicio'] ?>modules/cotizacion.php?moneda="+moneda+"&operacion="+operacion,
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inputCotizacion").value = moneda;
    }
    function cotActual(){
        var cDolar= $.ajax ({
            url: "<?php echo $GLOBALS['pathInicio'] ?>modules/cotizacion.php?moneda=2&operacion=1",
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("cDolar").innerHTML= cDolar;
        var vDolar= $.ajax ({
            url: "<?php echo $GLOBALS['pathInicio'] ?>modules/cotizacion.php?moneda=2&operacion=2",
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("vDolar").innerHTML= vDolar;
        var cEuro= $.ajax ({
            url: "<?php echo $GLOBALS['pathInicio'] ?>modules/cotizacion.php?moneda=3&operacion=1",
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("cEuro").innerHTML= cEuro;
        var vEuro= $.ajax ({
            url: "<?php echo $GLOBALS['pathInicio'] ?>modules/cotizacion.php?moneda=3&operacion=2",
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("vEuro").innerHTML= vEuro;
        
    }
    cotActual();
    setInterval(cotActual, 3000);
    function tablaCaja(){
        var tabla= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/tablaCaja.php?user=<?php echo $_SESSION['idUsuario'] ?>&fecha=<?php echo $fecha ?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("tablaCaja").innerHTML = tabla;
    }
    tablaCaja();
    setInterval(tablaCaja, 3000);
    function fechForm(){
        document.getElementById('fechForm').submit();
    }


  </script>

<!-- FUNCION DE ELIMINAR OPERACION -->
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

<!-- FUNCION DE ACTUALIZAR COT  -->
<div class="fondoVentana" id="fondoVentana2" onClick="">
    <div class="contVentana" >
        
        <form action="" method="POST">
                <input type="hidden"id="pass">
                <h3>EDITAR COTIZACION</h3>
                <input type="number" placeholder="COTIZACION" id="newCotizacion">
                <br>
                <input type="text" placeholder="CODIGO" id="codigo2">
                <button type="button" class="btnAceptar" onClick="editarCot()">Aceptar</button>
                <button type="button" class="btnCancelar" onClick="cerrar2()" >Cancelar</button>
            
        </form>
    </div>
</div>
<script>
    const fondoVentana2 = document.getElementById("fondoVentana2");
    function getToken(){
        var token= $.ajax ({
            url: '/cajas/modules/token2.php',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("pass").value = token;
    }
    getToken();
    setInterval(getToken, 1000);
    function editarCot(){
        const nuevaCot = document.getElementById('newCotizacion');
        const codigo2 = document.getElementById('codigo2');
        const pass = document.getElementById('pass');
        const inputCotizacion = document.getElementById('inputCotizacion');
        if(codigo2.value == pass.value){
            
            inputCotizacion.value = nuevaCot.value;
            cerrar2();
            
            recordatorioOp()
        }
    }
    function mostrar2(){
        fondoVentana2.style.display = "flex"
    }
    function cerrar2(){
        fondoVentana2.style.display = "none"
    }
</script>
<script>
function recordatorioOp(){
    const span = document.getElementById("recordatorio");
    const selecMoneda = document.getElementById("selectMoneda")
    let moneda = selecMoneda.options[selecMoneda.selectedIndex].value;
    let operacion = document.getElementById("selectOperacion").options[document.getElementById("selectOperacion").selectedIndex].value;
    let monto = document.getElementById("inputCantidad").value;
    let cot = document.getElementById("inputCotizacion").value;
    let v1 = 10;
    let v2 = 1200;
    
    texto = ""; 
    if(operacion == 1){
        if(moneda == 2){
            texto = "Pagar "+formatearNumeroConPuntos(monto*cot)+ " Pesos";
            // texto = "Cobrar "+formatearNumeroConPuntos(monto)+" Dolares, Pagar "+formatearNumeroConPuntos(monto*cot)+ " Pesos";
        }
        if(moneda == 3){
            texto = "Pagar "+formatearNumeroConPuntos(monto*cot)+" Pesos";
            // texto = "Cobrar "+formatearNumeroConPuntos(monto)+" Euros, Pagar "+formatearNumeroConPuntos(monto*cot)+" Pesos";
        }
    }
    if(operacion == 2){
        if(moneda == 2){
            texto = "Cobrar "+formatearNumeroConPuntos(monto*cot)+" Pesos";
            // texto = "Cobrar "+formatearNumeroConPuntos(monto*cot)+" Pesos, Pagar "+formatearNumeroConPuntos(monto)+ " Dolares";
        }
        if(moneda == 3){
            texto = "Cobrar "+formatearNumeroConPuntos(monto*cot)+" Pesos";
            // texto = "Cobrar "+formatearNumeroConPuntos(monto*cot)+" Pesos, Pagar "+formatearNumeroConPuntos(monto)+" Euros";
        }
    }
    span.textContent = texto;
}
    
</script>
<?php

    // for($i=1;$i<=5000;$i++){
    //     conectarDB("INSERT INTO `operaciones` (`idOperacion`, `idUsuario`, `fecha`, `hora`, `tipoOperacion`, `idMoneda`, `monto`, `cotizacion`, `estado`) VALUES (NULL, '1', '2023-08-03', '09:46:46', '1', '3', '20', '50', '1')");
    // }


function abrir_ventana_emergente($url) {
    // Generar código JavaScript para abrir una nueva ventana emergente
    echo '<script type="text/javascript">';
    echo 'var ventana=window.open("'.$url.'", "_blank", "width=100,height=100,top=100,left=100")';
    echo '</script>';
    echo '<script type="text/javascript">';
    echo 'setTimeout(function() { ventana.close(); }, 1000);';
    echo '</script>';
}

// Llamar a la función para abrir la ventana emergente

if($_SESSION['urlImprimir'] != ""){
    abrir_ventana_emergente($_SESSION['urlImprimir'] );
}

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $_SESSION['urlImprimir'] = "";
}
?>