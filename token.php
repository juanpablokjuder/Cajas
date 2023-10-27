<?php 
  require "app/app.php";
  validarGerenteGeneral();
  html("Token");
  menu();

  // ver(token());

  ?>


<div id="contToken"></div>
  <script type="text/javascript">
    function tiempoReal(){
        var token = $.ajax ({
            url: '/caja/modules/token.php',
            dataType: 'text',
            async: false,
        }).responseText;
        document.getElementById("contToken").innerHTML = token;
        console.log("a")
    }
    setInterval(tiempoReal, 1000);
  </script>

