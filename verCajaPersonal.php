<?php 
    require "app/app.php";
    if(!isset($_GET['fecha'])){
        $fecha = date("Y-m-d");
    }else{
        $fecha = $_GET['fecha'];
    }
    if(!isset($_GET['usuario'])){
      $idUser = $_SESSION['idUsuario'];
    }else{
      $idUser = $_GET['usuario'];
    }
    html("Caja");
    $usuario = new Usuarios;
    $usuario = $usuario->returnUsuario($idUser);
    menu();
    $operaciones = new Operaciones()
?>
        
<section class="contCaja">
    <div class="topCaja">

        <div class="cajaTablaTop">
            <table class="tftable" border="1px">
                <tr><th>Tipo de Caja</th><td>CAJA PERSONAL</td></tr>
                <tr><th>Dia</th><td><form action="" id="fechForm">
                    <input type="hidden"  name="usuario" value="<?php echo $idUser ?>">
                    <input type="date" name="fecha" onchangue="fechForm()" oninput="fechForm()" value="<?php echo $fecha ?>">
                </form></td></tr>
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
            <table class="tftable saldos" border="1px">
                <tr><th>Estadisticas</th><th>USD <img src="img/usd.png" alt=""></th><th>EUR <img src="img/eur.png" alt=""></th></tr>
                <tr><th>Comprado</th>
                    <td><?php echo $operaciones->compraDelDiaUsuario($idUser,$fecha,2); ?></td>
                    <td><?php echo $operaciones->compraDelDiaUsuario($idUser,$fecha,3); ?></td>
                </tr>
                <tr><th>Vendido</th>
                    <td><?php echo $operaciones->ventaDelDiaUsuario($idUser,$fecha,2); ?></td>
                    <td><?php echo $operaciones->ventaDelDiaUsuario($idUser,$fecha,3); ?></td>
                </tr>
                <tr><th>Spread</th>
                    <td><?php echo $operaciones->spreadDelDiaUsuario($idUser,$fecha,2); ?></td>
                    <td><?php echo $operaciones->spreadDelDiaUsuario($idUser,$fecha,3); ?></td>
                </tr>
               
            </table>
            <table class="tftable">
                <tr>
                    <th>Accion</th>
                </tr>
                  <tr>
                    <td><a href="buscarCajas.php" class="btn button" style="text-decoration:none">Volver</a></td>
                  </tr>
                  <tr>
                      <td><button type="button" onclick="print()" class="btn">Imprimir</button></td>
                </tr>
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

    
</section>

<!-- FUNCIONES TIEMPO REAL -->
<script type="text/javascript">
    function stock(){
        // STOCK INICIAL
        var instockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=1&user=<?php echo $idUser ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockPesos").innerHTML = instockPesos;
        var instockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=2&user=<?php echo $idUser ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockDolares").innerHTML = instockDolares;
        var instockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=3&user=<?php echo $idUser ?>&tipo=Inicial&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("inStockEuros").innerHTML = instockEuros;
        // STOCK FINAL
        if(document.querySelector('#finStockPesos') !== null){
        var finstockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=1&user=<?php echo $idUser ?>&tipo=Final&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockPesos").innerHTML = finstockPesos;
        var finstockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=2&user=<?php echo $idUser ?>&tipo=Final&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        if(!!document.getElementById("finStockDolares")){
            document.getElementById("finStockDolares").innerHTML = finstockDolares;

        }
        var finstockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=3&user=<?php echo $idUser ?>&tipo=Final&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("finStockEuros").innerHTML = finstockEuros;
        }
        // STOCK ACTUAL
        if(document.querySelector('#stockPesos') !== null){
        var stockPesos = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=1&user=<?php echo $idUser ?>&tipo=Actual&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockPesos").innerHTML = stockPesos;
        var stockDolares = $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=2&user=<?php echo $idUser ?>&tipo=Actual&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockDolares").innerHTML = stockDolares;
        var stockEuros= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/stock.php?moneda=3&user=<?php echo $idUser ?>&tipo=Actual&fecha=<?php echo $fecha?>',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("stockEuros").innerHTML = stockEuros;
        }
    }
    stock();
    setInterval(stock, 3000);
    
    function tablaCaja(){
        var tabla= $.ajax ({
            url: '<?php echo $GLOBALS['pathInicio'] ?>modules/tablaCaja.php?user=<?php echo $idUser ?>&fecha=<?php echo $fecha ?>',
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
