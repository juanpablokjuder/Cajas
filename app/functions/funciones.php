<?php

function html($nombre){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo $GLOBALS['pathInicio'] ?>/css/app.css">
        <title> <?php echo $nombre?></title>
        <link rel="icon" href="<?php echo $GLOBALS['pathInicio'] ?>img/logo.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;800&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="<?php echo $GLOBALS['pathInicio'] ?>js/app.js"></script>
    </head>
    <body>

    <?php
        if($_SERVER['REQUEST_METHOD']=="GET"){
            MostrarError();
        }
}
function conectarDB($sql){
    $conexion= mysqli_connect('localhost','root','','cajas');
    $resultado= mysqli_query($conexion, $sql);
    return $resultado;
}
function ver($array){
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
}



function MostrarError(){
    if(isset($_SESSION["ERROR"])){
        if($_SESSION["ERROR"]!=""){
            ?>
            <div class="contError" id="error">
                <?php echo $_SESSION["ERROR"] ?>
            </div>
            <?php 
            $_SESSION["ERROR"]="";
        }
    }

}
function error($string){
    $_SESSION["ERROR"]=$string;
    
}
function eliminarStringHastaCaracter($string,$caracter){
    while($string[0]!=$caracter[0]){
        $string=substr($string, 1);
    }
    $string=substr($string, 1);
    return $string;
}



function menu(){
    ?>
    <div class="menu">
    <div>
        <a href="<?php echo $GLOBALS['pathInicio'] ?>">
        <img src="img/logo.png" alt="">
        </a>
        
    </div>
        <div class="botones">
        <a href="<?php echo $GLOBALS['pathInicio'] ?>cajaPersonal.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hexagon-letter-p" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
            <path d="M10 12h2a2 2 0 1 0 0 -4h-2v8" />
            </svg>
        </a>
        <a href="<?php echo $GLOBALS['pathInicio'] ?>cajaSucursal.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hexagon-letter-s" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
            <path d="M10 15a1 1 0 0 0 1 1h2a1 1 0 0 0 1 -1v-2a1 1 0 0 0 -1 -1h-2a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1" />
            </svg>
        </a>
        <a href="<?php echo $GLOBALS['pathInicio'] ?>cajaGeneral.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hexagon-letter-g" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                <path d="M14 8h-2a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2v-4h-1" />
                </svg>
        </a>
        <a href="<?php echo $GLOBALS['pathInicio'] ?>cotizacion.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-cashapp" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M17.1 8.648a.568 .568 0 0 1 -.761 .011a5.682 5.682 0 0 0 -3.659 -1.34c-1.102 0 -2.205 .363 -2.205 1.374c0 1.023 1.182 1.364 2.546 1.875c2.386 .796 4.363 1.796 4.363 4.137c0 2.545 -1.977 4.295 -5.204 4.488l-.295 1.364a.557 .557 0 0 1 -.546 .443h-2.034l-.102 -.011a.568 .568 0 0 1 -.432 -.67l.318 -1.444a7.432 7.432 0 0 1 -3.273 -1.784v-.011a.545 .545 0 0 1 0 -.773l1.137 -1.102c.214 -.2 .547 -.2 .761 0a5.495 5.495 0 0 0 3.852 1.5c1.478 0 2.466 -.625 2.466 -1.614c0 -.989 -1 -1.25 -2.886 -1.954c-2 -.716 -3.898 -1.728 -3.898 -4.091c0 -2.75 2.284 -4.091 4.989 -4.216l.284 -1.398a.545 .545 0 0 1 .545 -.432h2.023l.114 .012a.544 .544 0 0 1 .42 .647l-.307 1.557a8.528 8.528 0 0 1 2.818 1.58l.023 .022c.216 .228 .216 .569 0 .773l-1.057 1.057z" />
            </svg>
        </a>
        <a href="<?php echo $GLOBALS['pathInicio'] ?>token.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock-open" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
            <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
            <path d="M8 11v-5a4 4 0 0 1 8 0" />
            </svg>
        </a>
        <a href="<?php echo $GLOBALS['pathInicio'] ?>estadisticas.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop-analytics" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" />
                <path d="M7 20h10" />
                <path d="M9 16v4" />
                <path d="M15 16v4" />
                <path d="M9 12v-4" />
                <path d="M12 12v-1" />
                <path d="M15 12v-2" />
                <path d="M12 12v-1" />
            </svg>
        </a>
        <a href="<?php echo $GLOBALS['pathInicio'] ?>cerrarSesion.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon red icon-tabler icon-tabler-logout" width="48" height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="#F13535" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
            <path d="M7 12h14l-3 -3m0 6l3 -3" />
            </svg>
        </a>
        </div>
    </div>
    <?php
}

function token(){
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
    $token ="";
    for($i=0;$i<=5;$i++){
        $token .= $cadena[rand(0,34)];
    }
    return $token;

}
function generarToken(){
if(conectarDB("SELECT * FROM `token` 
   WHERE TIMESTAMPDIFF(SECOND, `fecha_hora`, NOW()) >= 59")->num_rows>0){
    $token = token();
    conectarDB("UPDATE `token` SET `token`='$token', `fecha_hora` = NOW() ");
}
}

function validarGerenteGeneral(){
    if($_SESSION['rol']!=2){
        // session_start();
        $_SESSION['ERROR']="ACCESO DENEGADO";
         header("location: ".$GLOBALS['pathInicio']);
        die;
    }
}
function validarGerenteOEncargado(){
    if($_SESSION['rol']==0){
        // session_start();
        $_SESSION['ERROR']="ACCESO DENEGADO";
         header("location: ".$GLOBALS['pathInicio']);
        die;
    }
}
function obtenerNombreDia($fecha) {
    // Divide la fecha en día, mes y año
    list($dia, $mes, $anio) = explode('/', $fecha);
    
    // Convierte la fecha en un timestamp
    $timestamp = strtotime("$anio-$mes-$dia");
    
    // Obtiene el nombre abreviado del día
    $nombreDia = date('D', $timestamp);
    if($nombreDia == "Mon"){
        $nombreDia = "Lunes";
    }
    if($nombreDia == "Tue"){
        $nombreDia = "Martes";
    }
    if($nombreDia == "Wed"){
        $nombreDia = "Miercoles";
    }
    if($nombreDia == "Thu"){
        $nombreDia = "Jueves";
    }
    if($nombreDia == "Fri"){
        $nombreDia = "Viernes";
    }
    if($nombreDia == "Sat"){
        $nombreDia = "Sabado";
    }
    if($nombreDia == "Sun"){
        $nombreDia = "Domingo";
    }
    return $nombreDia;
}
function obtenerDiasEnMes($fecha) {
    $mes = $fecha[5].$fecha[6];
    $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
    // Validar que el número de mes esté dentro del rango válido
    if ($mes < 1 || $mes > 12) {
        return "Número de mes inválido";
    }

    // Validar el año (puedes agregar más validaciones si es necesario)
    if ($anio < 1) {
        return "Año inválido";
    }

    // Obtener el número de días en el mes y año especificados
    $diasEnMes = date('t', mktime(0, 0, 0, $mes, 1, $anio));

    return $diasEnMes;
}
function llenarArrayConNumeros($numero) {
    // Validar que el número esté en el rango válido (28-31)
    if ($numero < 28 || $numero > 31) {
        return "Número fuera de rango";
    }

    $arrayNumeros = array();

    for ($i = 1; $i <= $numero; $i++) {
        $arrayNumeros[] = $i;
    }

    return $arrayNumeros;
}
function llenarArrayConCeros($numero) {
    // Validar que el número esté en el rango válido (28-31)
    if ($numero < 28 || $numero > 31) {
        return "Número fuera de rango";
    }

    $arrayNumeros = array();

    for ($i = 1; $i <= $numero; $i++) {
        $arrayNumeros[] = 0;
    }

    return $arrayNumeros;
}
function obtener_ip_local() {
    // Si la dirección IP del cliente está detrás de un proxy, 
    // la dirección IP real del cliente podría estar en la cabecera 'HTTP_X_FORWARDED_FOR'
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // Intentamos obtener la dirección IPv4 del cliente directamente desde 'REMOTE_ADDR'
        $ip = $_SERVER['REMOTE_ADDR'];
        // Verificamos si la dirección IP es una dirección IPv6
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            // Si es IPv6, forzamos el uso de IPv4
            $ip = $_SERVER['SERVER_ADDR'];
        }
    }
    return $ip;
}
function ImprimirTicket($fecha,$hora,$operacion,$moneda,$monto,$cot,$total){
    $ip_local = obtener_ip_local();
    if($ip_local == "::1"){$ip_local = "192.168.0.64/Cajas";}
    $url = "192.168.0.64/Cajas/ticket.php?fecha=".$fecha."&hora=".$hora."&operacion=".$operacion."&moneda=".$moneda."&monto=".$monto."&cot=".$cot."&total=".$total;
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    function ImprimirTicket(url) {
        $.ajax({
            url: url,
            success: function(response) {
                console.log(response); // Esto es opcional, puedes quitarlo si no lo necesitas
            },
            error: function(xhr, status, error) {
                console.error("Error al imprimir el ticket:", status, error);
            }
        });
    }
    ImprimirTicket("<?php echo $url ?>")
    
    </script>
    <?php
}
