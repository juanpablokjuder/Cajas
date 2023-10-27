<?php
require "app/app.php";
validarGerenteGeneral();
html("Usuarios");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['nuevo'])){
    $user = new Usuario;
    $usuarios = new Usuarios;
    $user->nombre = $_POST['nombre'];
    $user->idSucursal = $_POST['idSucursal'];
    $user->contra = $_POST['contra'];
    $user->rol = $_POST['rol'];
    $user->estado = 1;

    $usuarios->insertUsuario($user);
    header("location: ./usuarios.php");
  }
  if(isset($_POST['editar'])){
    $user = new Usuario;
    $usuarios = new Usuarios;
    $user->idUsuario = $_POST['idUsuario'];
    $user->nombre = $_POST['nombre'];
    $user->idSucursal = $_POST['idSucursal'];
    $user->contra = $_POST['contra'];
    $user->rol = $_POST['rol'];
    $user->estado = $_POST['estado'];
    $usuarios->updateUsuario($user);
    header("location: ./usuarios.php");
  }


}
menu();


?>

<section>
  <div class="contenedor"><h1>Usuarios</h1></div>
  <div class="contFlex2">
    <div class="contenedor">
      <h2>Nuevo</h2>
      <form method="post" class="formFlex">
        <input type="hidden" name="nuevo" value="1">
        <select name="idSucursal" id="" placeholder="Sucursales" required>
          <?php $sucursales = new Sucursales;
          foreach($sucursales->returnSucursales() as $suc){if($suc->estado==1){ ?>
          <option value="<?php echo $suc->idSucursal ?>"><?php echo $suc->nombre ?></option>
          <?php }}?>
        </select>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="contra" placeholder="Contraseña" required>
        <select name="rol" required>
          <option value="0">Cajero</option>
          <option value="1">Encargado</option>
          <option value="2">Gerente</option>
        </select>
        <button class="btn">Guardar</button>
      </form>
    </div>
    <div class="contenedor">
      <h2>Editar</h2>
      <form method="post" class="formFlex">
        <?php
          if(isset($_POST['idEditar'])){
            $usuarios = new Usuarios;
            $user = $usuarios->returnUsuario($_POST['idEditar']);
          }

        ?>
        <input type="hidden" name="editar" value="1">
        <input type="text" name="idUsuario" id="idUsuario" value="<?php  if(isset($_POST['idEditar'])){echo $user->idUsuario;}?>" readOnly>
        <select name="idSucursal" placeholder="Sucursales" required>
          <?php if(isset($_POST['idEditar'])){
            $sucursales = new Sucursales;
            $suc = $sucursales->returnSucursal($user->idSucursal); 
          ?>
          <option value="<?php echo $suc->idSucursal ?>"><?php echo $suc->nombre ?></option>
          <?php }?>
        </select>
        <input type="text" name="nombre" placeholder="Nombre" required value="<?php if(isset($_POST['idEditar'])){echo $user->nombre;} ?>">
        <input type="text" name="contra" placeholder="Contraseña" required value="<?php if(isset($_POST['idEditar'])){echo $user->contra;} ?>">
        <select name="rol" required>
          <option value="0" <?php if(isset($_POST['idEditar'])){if($user->rol == 0){echo "Selected"; }} ?>>Cajero</option>
          <option value="1" <?php if(isset($_POST['idEditar'])){if($user->rol == 1){echo "Selected"; }} ?>>Encargado</option>
          <option value="2" <?php if(isset($_POST['idEditar'])){if($user->rol == 2){echo "Selected"; }} ?>>Gerente</option>
        </select>
        <select name="estado">
          <option value="1" <?php if(isset($_POST['idEditar'])){if($user->estado == 1){echo "Selected"; }} ?>>Activo</option>
          <option value="0" <?php if(isset($_POST['idEditar'])){if($user->estado == 0){echo "Selected"; }} ?>>Inactivo</option>
        </select>
        <button class="btn">Guardar</button>
      </form>
    </div>
  </div>
  <div class="contenedor">
    <table class="tftable Caja" border="1px" style="overflow-x: hidden;">
        <tr class="titulo"><th>ID</th><th>Sucursal</th><th>Nombre</th><th>Contraseña</th><th>Rango</th><th>Estado</th></tr>
        <?php
        $usuarios = new Usuarios;
        $usuarios = $usuarios->returnUsuarios();
        foreach($usuarios as $user){
          $sucursal = new Sucursales;
          $suc = $sucursal->returnSucursal($user->idSucursal);
          if($user->rol == 0){$rol = "Cajero";}
          if($user->rol == 1){$rol = "Encargado";}
          if($user->rol == 2){$rol = "Gerente";}
          if($user->estado == 0){$estado = "Inactivo";}
          if($user->estado == 1){$estado = "Activo";}
        ?>
        <tr><td><?php echo $user->idUsuario ?></td><td><?php echo $suc->nombre ?></td><td><?php echo $user->nombre ?></td><td><?php echo $user->contra ?></td><td><?php echo $rol ?></td><td><?php echo $estado ?></td><td><form method="post"><button class="btn" name="idEditar" value="<?php echo $user->idUsuario ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
  <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
  <path d="M16 5l3 3" />
</svg></button></form></td></tr>
        <?php }?>
    </table>
  </div>
</section>