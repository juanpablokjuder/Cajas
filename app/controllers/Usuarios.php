<?php 

class Usuarios{
  public function iniciarSesion($user,$pass){
      $consulta=conectarDB("SELECT * FROM `usuarios` WHERE `nombre`='$user'");
      if($consulta->num_rows==1){
          $c=mysqli_fetch_assoc($consulta);
          if($c['contra']===$pass){
            if( $c['estado'] == 1 ){
              session_start();
              $_SESSION['idUsuario'] = $c['idUsuario'];
              $_SESSION['idSucursal'] = $c['idSucursal'];
              $_SESSION['rol'] = $c['rol'];
              return true;
            }else{
              error("Usuario No Habilitado");
            }
          }else{
            error("Contrasena incorrecta");
          }
      }else{
          error("Usuario Inexistente");
      }
  }
  public function insertUsuario(Usuario $user){
    
    $consulta = conectarDB("INSERT INTO `usuarios`
    (`idSucursal`, `nombre`, `contra`, `rol`)
    VALUES
    ('$user->idSucursal','$user->nombre',
    '$user->contra','$user->rol')
     ");
  }
  public function returnUsuario(int $id){
      $consulta = conectarDB(" SELECT * FROM `usuarios` WHERE `idUsuario`='$id' ");
      $user = new Usuario;
      $c = mysqli_fetch_assoc($consulta);
      $user->idUsuario = $c['idUsuario'];
      $user->idSucursal = $c['idSucursal'];
      $user->nombre = $c['nombre'];
      $user->contra = $c['contra'];
      $user->rol = $c['rol'];
      $user->estado = $c['estado'];
      return $user;  
  }
  public function returnUsuarios(){
    $consulta = conectarDB(" SELECT * FROM `usuarios`");
    $users = [];
    foreach($consulta as $c){
      $user = new Usuario;
    
      $user->idUsuario = $c['idUsuario'];
      $user->idSucursal = $c['idSucursal'];
      $user->nombre = $c['nombre'];
      $user->contra = $c['contra'];
      $user->rol = $c['rol'];
      $user->estado = $c['estado'];

      $users[] = $user;
    }
    return $users;  
  }
  public function updateUsuario(Usuario $user){
    
    $consulta = conectarDB("UPDATE `usuarios` SET
    `idSucursal`='$user->idSucursal',
    `nombre`='$user->nombre',
    `contra`='$user->contra',
    `rol`='$user->rol',
    `estado`='$user->estado'
     WHERE `idUsuario` = '$user->idUsuario' 
     ");
  }
  public function deleteUsuario(int $id){
    
    $consulta = conectarDB("UPDATE `usuarios` SET
    `estado`='0'
     WHERE `idUsuario` = '$id' 
     ");
  }
  public function restartUsuario(int $id){
    
    $consulta = conectarDB("UPDATE `usuarios` SET
    `estado`='1'
     WHERE `idUsuario` = '$id' 
     ");
  }
  public function returnUsuariosSucursal($idSucursal){
    $consulta = conectarDB("SELECT * FROM `usuarios` WHERE `idSucursal` = '$idSucursal' AND `estado` = 1");
    $users = [];
    foreach($consulta as $c){
      $user = new Usuario;
    
      $user->idUsuario = $c['idUsuario'];
      $user->idSucursal = $c['idSucursal'];
      $user->nombre = $c['nombre'];
      $user->contra = $c['contra'];
      $user->rol = $c['rol'];
      $user->estado = $c['estado'];
      $users[] = $user;
   
    }
    
    return $users; 
  }
  public function returnUsuarioSucursalYGerentes($idSucursal, $idUsuario){
    $consulta = conectarDB("SELECT * FROM `usuarios` WHERE `idSucursal` = '$idSucursal' AND `estado` = 1");
    $users = [];
    foreach($consulta as $c){
      $user = new Usuario;
    
      $user->idUsuario = $c['idUsuario'];
      $user->idSucursal = $c['idSucursal'];
      $user->nombre = $c['nombre'];
      $user->contra = $c['contra'];
      $user->rol = $c['rol'];
      $user->estado = $c['estado'];
      if($user->idUsuario != $idUsuario){
        $users[] = $user;
      }
      
    }
    $consulta = conectarDB("SELECT * FROM `usuarios` WHERE `rol` > 0 AND `estado` = 1");
    foreach($consulta as $c){
      $user = new Usuario;
    
      $user->idUsuario = $c['idUsuario'];
      $user->idSucursal = $c['idSucursal'];
      $user->nombre = $c['nombre'];
      $user->contra = $c['contra'];
      $user->rol = $c['rol'];
      $user->estado = $c['estado'];
      if($user->idUsuario != $idUsuario){
        $users[] = $user;
      }
      
    }
    return $users; 
  }
  public function returnGerentesSucursal($idSucursal, $idUsuario){
    $consulta = conectarDB("SELECT * FROM `usuarios` WHERE `idSucursal` = '$idSucursal' AND `rol` > 0 AND `estado` = 1");
    $users = [];
    foreach($consulta as $c){
      $user = new Usuario;
    
      $user->idUsuario = $c['idUsuario'];
      $user->idSucursal = $c['idSucursal'];
      $user->nombre = $c['nombre'];
      $user->contra = $c['contra'];
      $user->rol = $c['rol'];
      $user->estado = $c['estado'];
      if($user->idUsuario != $idUsuario){
        $users[] = $user;
      }
      
    }
    return $users;  
  }
  
  
}
