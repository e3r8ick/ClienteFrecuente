<?php
//clase para cerrar sesion, en esta clase solo se inicializa la sesion
//se destruye y se redirecciona a la pagina de inicio.

session_start();
session_destroy();
setcookie("COD_CLIENTE", "", time()-3600,'/');
setcookie("NOM_CLIENTE", "", time()-3600,'/');
setcookie("FECHA1", "", time()-3600,'/');
setcookie("ADMIN", "", time()-3600,'/');
setcookie("FECHA2", "", time()-3600,'/');
header('location: ../../index.php?msg= SESION FINALIZADA CORRECTAMENTE.');
?>
