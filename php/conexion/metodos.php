<?php

// *************************** CLASS METODOS ***************************************//
class Metodos{

// *************************** LOGIN USER *****************************************//

//se reciben por parametros las variables necesarias para realizar la validacion del login.
public function LoginUser($Ppassword, $Pusuario, $Pcia, $Psucursal){

  //se limpian las variables
  $Ppassword = $this->limpiarVariable($Ppassword);
  $Pusuario = $this->limpiarVariable($Pusuario);
  $Pcia = $this->limpiarVariable($Pcia);
  $Psucursal = $this->limpiarVariable($Psucursal);

  //se instancia la clase conexion y se le otorga el string de conexion a una nueva variable
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  //se crea la sentencia SQL
  $sql = "SELECT COD_USUARIO, DES_USUARIO, COD_CIA, SUCURSAL, CLAVE_USUARIO, TIPO, COD_AGENTE FROM WEBLOGINVIEW WHERE COD_USUARIO = ? AND  CLAVE_USUARIO = ? AND COD_CIA = ? AND SUCURSAL = ? ";

  //se prepara el statement con la sentencia previamente creada
  $stmt = $conexion->prepare($sql);

  if ($stmt) {
    //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
    //que coincida con el usuario y la clave ademas del cia.
    //en el execute se agregan las variables por medio de un array.
    $stmt->execute(array($Pusuario, $Ppassword, $Pcia, $Psucursal));
    $result = $stmt->fetch();

    //se cierra la conexion
    $conexion = null;

    //se retorna el $result;
    return $result;
  }else{
    //si el statement da error, se retorna falso.
    return false;
  }

}

// *************************** /LOGIN USER *****************************************//

// *************************** COD_AGENTE ********************************************//

//funcion que se encarga de obtener el codigo del agente.
public function get_CodAgente($Pcia, $Pusuario, $Psucursal){

  //se limpian las variables
  $Pusuario = $this->limpiarVariable($Pusuario);
  $Pcia = $this->limpiarVariable($Pcia);
  $Psucursal = $this->limpiarVariable($Psucursal);

  //se instancia la clase conexion y se le otorga el string de conexion a una nueva variable
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  //se establece
  $sql = "SELECT CODIGOAGENTE( ?, ?, ?) as VALOR FROM DUAL";

  //se establece el query del sql
  $stmt = $conexion->prepare($sql);

  //se enlazan los parametros con la sentencia de manera segura
  // $stmt->bindParam(':cia', $Pcia);
  // $stmt->bindParam(':usuario', $Pusuario);

  //se realiza un execute y un fetch al primer resultado del select.
  $stmt->execute(array($Pcia, $Pusuario, $Psucursal));
  $agente = $stmt->fetch();

  if ($agente['VALOR'] == null) {
    //se establece el select de la nueva consulta.
    $sql = "SELECT NEWCODIGOAGENTE( ?, ?, ?) as VALOR FROM DUAL";

    //se establece el query del sql
    $stmt = $conexion->prepare($sql);

    //se enlazan los parametros con la sentencia de manera segura
    // $stmt->bindParam(':cia', $Pcia);
    // $stmt->bindParam(':usuario', $Pusuario);

    //se realiza un execute y un fetch al primer resultado del select.
    $stmt->execute(array($Pcia, $Pusuario, $Psucursal));
    $agente = $stmt->fetch();

    //se realiza el update a la BD donde el codigo de usuario se reestablece.
    $UPDATE = "UPDATE SEG_USUARIO SET COD_AGENTE = ? WHERE COD_CIA = ? AND COD_USUARIO = ? AND COD_SUCURSAL = ?";
    $PrepQuery = $conexion->prepare($UPDATE);
    $PrepQuery->execute(array($agente['VALOR'], $Pcia, $Pusuario, $Psucursal));

    // $commit = "COMMIT";
    // $prepCommit = $conexion->query($commit);
    // $prepCommit->execute();

  }

  //se cierra la conexion.
  $conexion = null;

  //se retorna el valor de agente.
  return $agente;
}

// *************************** /COD_AGENTE ******************************************//

// *************************** COD_CIA ********************************************//

//funcion que obtiene la lista de codigos CIA
public function get_ListaCodCia(){
  $rows = null;
  //se instancia la conexion
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  //se seleccionan los codigos cia de la tabla
  $sql = "SELECT COD_CIA, DES_CIA FROM GEN_COMPANIA ORDER BY COD_CIA";
  $stmt = $conexion->query($sql);
  //se realiza el fetch para obtener los datos.
  $stmt->execute();
  while ($result = $stmt->fetch()) {
    $rows[] = $result;
  }

  //se realiza un foreach que inserta todos los datos en un arreglo de resultado.

  //se cierra la conexion.
  $conexion = null;

  //se retorna el arreglo con la informacion cargada.
  return $rows;
}

// *************************** /COD_CIA ********************************************//


// *************************** SUCURSALES ******************************************//

//funcion que retorna las sucursales.
public function getSucursal($cia){
//se limpia la variable de la sucursal.
$cia = $this->limpiarVariable($cia);
//se inicializa la variable que va a ser devuelta
$rows = null;

//se instancia la conexion en una variable de conexion y se obtiene el string de
//conexion.
$con = new Conexion();
$conexion = $con->get_Conexion();

//se establece la consulta
$sql = "SELECT SUCURSAL, DESCRIPCION FROM GEN_SUCURSAL WHERE COD_CIA = ? ORDER BY COD_CIA";
$stmt = $conexion->prepare($sql);
//se concatena la variable para realizar la consulta

//se establece un while que carga cada fila en un campo del arreglo
$stmt->execute(array($cia));
while ($result = $stmt->fetch()) {
  $rows[] = $result;
}

//se cierra la conexion.
$conexion = null;

//se retornan las filas en el arreglo.
return $rows;

}

// *************************** /SUCURSALES *****************************************//


// *************************** LIMPIAR VAR *****************************************//

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

// *************************** /LIMPIAR VAR *****************************************//

}

// *************************** /CLASS METODOS ***************************************//

?>
