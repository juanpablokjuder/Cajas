<?php 
  require "app/app.php";
  
  validarGerenteGeneral();
  html("Estadisticas");
  menu();

?>

<div class="contenedor">
  <h1>Ver Caja Personal</h1>
</div>
<div class="contenedor">
<table class="tftable Caja" border="1px" style="overflow-x: hidden;">
    <tr class="titulo">
      <th>Sucursal</th>
      <th>Usuario</th>
      <th>Ver</th>
    </tr>
    <?php 
      $usuarios = new Usuarios();
      $usuarios = $usuarios->returnUsuarios();
      
      foreach($usuarios as $user){
      $sucursal = new Sucursales;
      $sucursal = $sucursal->returnSucursal($user->idSucursal)
    ?>
    <tr>
        <td><?php echo $sucursal->nombre ?></td>
        <td><?php echo $user->nombre ?></td>
        <td><a href="verCajaPersonal.php?usuario=<?php echo $user->idUsuario ?>" class="btn" style="text-decoration:none">Ver</a></td>
    </tr>
    <?php }?>
</div>