<?php
require "app/app.php";
validarGerenteGeneral();
html("Sucursales");
menu();

if($_SERVER['REQUEST_METHOD'] == "POST"){
  $sucursales = new Sucursales();
  
  if(isset($_POST['eliminar'])){
    $sucursales->deleteSucursal($_POST['eliminar']);unset($_POST);
  }
  if(isset($_POST['restaurar'])){
    $sucursales->restartSucursal($_POST['restaurar']);unset($_POST);
  }
  if(isset($_POST['idSucursal'])){
    if($_POST['idSucursal'] == ""){
      $sucursales->insertSucursal($_POST['nombre']);
    }else{
      $sucursales->updateSucursal($_POST['nombre'],$_POST['idSucursal']);
    }
    unset($_POST);
  }
}
?>

<section>
  <div class="contenedor">
    <h1>Sucursales</h1>
  </div>
  <div class="contenedor">
    <form action="" method="post">
      <h3 id="h3suc">Nueva Sucursal</h3>
      <button  class="btn" type="button" onclick="nuevaSuc()">Nuevo</button>
      <input type="hidden" id="idSuc" name="idSucursal">
      <input type="text" name="nombre" value= "<?php if(isset($_POST['nombreSuc'])){echo $_POST['nombreSuc'];} ?>">
      <button class="btn">Guardar</button>
    </form>
  </div>
  <div class="contenedor">
    <div class="contSucursal">
    <?php 
      $sucursales = new Sucursales();
      $sucursales = $sucursales->returnSucursales();
      foreach($sucursales as $sucursal){ ?>
      <form action="" method="post" class="sucursal">
        <input type="hidden" name="nombreSuc" value="<?php echo $sucursal->nombre ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon <?php if($sucursal->estado == 0 ){echo 'red';} ?> icon-tabler icon-tabler-building-store" width="76" height="76" viewBox="0 0 24 24" stroke-width="1" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M3 21l18 0" />
          <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
          <path d="M5 21l0 -10.15" />
          <path d="M19 21l0 -10.15" />
          <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
        </svg>
        <p><?php echo $sucursal->nombre; ?></p>
        <div class="botonesSuc">
          <button name="editar" value="<?php echo $sucursal->idSucursal ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon  icon-tabler icon-tabler-edit" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
              <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
              <path d="M16 5l3 3" />
            </svg>
          </button>
          <?php if($sucursal->estado == 1){ ?>
          <button name="eliminar" value="<?php echo $sucursal->idSucursal ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon red icon-tabler icon-tabler-trash" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M4 7l16 0" />
              <path d="M10 11l0 6" />
              <path d="M14 11l0 6" />
              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>
          </button>
          <?php }else{ ?>
          <button name="restaurar" value="<?php echo $sucursal->idSucursal ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon green icon-tabler icon-tabler-restore" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00b341" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M3.06 13a9 9 0 1 0 .49 -4.087" />
              <path d="M3 4.001v5h5" />
              <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
            </svg>
          </button>
          <?php } ?>
        </div>
      </form>
      <?php
        
      }
    ?>
    </div>

  </div>
</section>
<script>
  const h3 = document.getElementById("h3suc");
  const inputId = document.getElementById("idSuc");
  function nuevaSuc(){
    
    h3suc.textContent = "Nueva Sucursal";

  }
</script>
<?php
if(isset($_POST['editar'])){
?>
<script>
  h3suc.textContent = "Editar Sucursal";
  inputId.value = <?php echo $_POST['editar'] ?>
</script>
<?php }?>
