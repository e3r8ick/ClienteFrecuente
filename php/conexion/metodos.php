<?php

// *************************** CLASS METODOS ***************************************//
class Metodos{

// *************************** LOGIN USER *****************************************//

//se reciben por parametros las variables necesarias para realizar la validacion del login.
public function LoginUser($Ppassword, $Pusuario){

  echo "<script>console.log( 'Debug Objects: " . "Login2". "' );</script>";

  //se limpian las variables
  $Ppassword = $this->limpiarVariable($Ppassword);
  $Pusuario = $this->limpiarVariable($Pusuario);
  //se instancia la clase conexion y se le otorga el string de conexion a una nueva variable
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  //se crea la sentencia SQL
  $sql = "SELECT COD_CLIENTE, NOM_CLIENTE, CEDULA, NUM_TELEFONO1, NUM_TELEFONO2, NUM_FAX, EMAIL, DIRECCION_ENVIO, CONTRASENIA FROM GEN_CLIENTE WHERE COD_CLIENTE = ? AND CONTRASENIA = ?";

  //se prepara el statement con la sentencia previamente creada
  $stmt = $conexion->prepare($sql);

  if ($stmt) {
    //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
    //que coincida con el usuario y la clave ademas del cia.
    //en el execute se agregan las variables por medio de un array.
    $stmt->execute(array($Pusuario, $Ppassword));
    $result = $stmt->fetch();

    //se cierra la conexion
    $conexion = null;

    //se retorna el $result;
    echo "<script>console.log( 'Debug Objects: " . "result". "' );</script>";
    return $result;
  }else{
    //si el statement da error, se retorna falso.
    echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
    return false;
  }

}

public function RegisterUser( $Pusuario, $Ppassword, $PpasswordC){

  echo "<script>console.log( 'Debug Objects: " . "register". "' );</script>";

  //se instancia la clase conexion y se le otorga el string de conexion a una nueva variable
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  if($Ppassword == $PpasswordC){
    try{
      //setear los errores
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //se crea la sentencia SQL
      $sql = "UPDATE GEN_CLIENTE SET CONTRASENIA='".$Ppassword."' WHERE COD_CLIENTE='".$Pusuario."';";
      //prepara el statement
      $stmt = $conexion->prepare($sql);
      // ejecuta el query
      $stmt->execute();
      echo "<script>console.log( 'Debug Objects: " . "Update". "' );</script>";
    }
    catch(PDOException $e){
        echo "<script>console.log( 'Debug Objects: " .$e->getMessage(). "' );</script>";
    }
  }else{
    header('location: ../index.php?msg=CONTRASEÑA NO COINCIDE.');
  }
  $conexion = null;
  return true;
  }


  //funcion que limpia la variable.
  public function limpiarVariable($var){
    //se limpia la variable de cualquier slash, backslash o etiqueta.
    $var = strip_tags($var);
    $var = stripslashes($var);
    $var = stripcslashes($var);
    // $var = "'".$var."'";
    //se devuelve la variable
    return $var;
  }

}
?>
