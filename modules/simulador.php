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
   }
 </style>
 <section class="contSimulador">
    <div class="topSimulador">
      <h1 class="tituloSimulador">Simulador</h1>
    </div>
    <div id="tablaCaja2">
    
    </div>
 </section>
<script>
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