<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

  <?php
  // se inicia la sesion
  session_start();

  // se incluye el header de la pagina
  //include 'header.php';

  //se valida si se ha iniciado sesion.
  if (!isset($_SESSION['username'])) {
  	//si no existe la sesion, se redireciona al usuario con el mensaje de que inicie sesion.
  	header('location: ../index.php?msg=Favor Iniciar Sesion.');
  }
  ?>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="../css/perfil.css" type="text/css" media="screen">
    <link rel="stylesheet" href="../css/font-awesome.css" >

     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
    <![endif]-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript" ></script>
    <script src="../js/perfil.js" type="text/javascript"></script>

</head>

 <body>

 <div class="mainWrap">

 <a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder"></i>Menu</a>

    <nav>
    <ul class="menu">
   <li><a href="../index.php"><i class="icon-home"></i>INICIO</a>
   </li>
  <li><a  href="perfil.php"><i class="icon-user"></i>PEFIL</a></li>
  </li>
  <li><a  href="historial.php"><i class="icon-list-ul"></i>HISTORIAL DE TRANSACCIONES</a></li>
  <li><a  href="ayuda.php"><i class="icon-envelope-alt"></i>AYUDA</a></li>
  <li><a  href="#" onclick="DoLogout()"><i class="icon-off"></i>CERRAR SESIÓN</a></li>
  <script>
    //funcion que muestra una confirm box para
    //verificar si se desea cerrar sesion.
    function DoLogout(){
      console.log("cerrar sesión");
      //Ingresamos un mensaje a mostrar
       var mensaje = confirm("¿Desea cerrar sesión?");
       //Detectamos si el usuario acepto el mensaje
       if (mensaje) {
         document.cookie = COD_CLIENTE + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
         window.location.replace("metodos/logout.php");
       }
       //Detectamos si el usuario denegó el mensaje
       else {
         window.location.replace("perfil.php");
    }
  }
  </script>
  </ul>
  </nav>
 </div><!--end mainWrap-->


 <table style="margin: 0 auto;">
   <br></br>
    <tr>
      <td align="center" style="text-align:center;">
        <div class="well" style="text-align:center;">
           <ul class="nav nav-tabs" style="text-align:center;">
             <li class="active"><h1 href="#home" data-toggle="tab" >Historial de Transacciones</h1></li>
           </ul>
           <br></br>
           <div id="myTabContent" class="tab-content" style="text-align:center;">
             <div class="tab-pane active in" id="home">
               <form id="date" action="metodos/getHistorial.php" method="post" name="date">
                 <input id="date1" name="date1" type="date" data-date-inline-picker="true" />
                 <input id="date2" name="date2" type="date" data-date-inline-picker="true" />
                 <br></br>
                 	<div>
               	    <button type="submit" class="btn btn-primary">Generar historial</button>
               	</div>
               </form>
             </div>
           </div>
         </div>
      </td>
    </tr>
 </table>

</body>

<script>
$(document).ready(function () {
  $("#success-alert").hide();
  $.ajax({
    type: "GET",
    url: "metodos/getDatos.php",
    success: function(data){
    console.log("data: "+data);
    var obj = $.parseJSON(data);
    $('#NOM_CLIENTE').html(obj.NOM_CLIENTE);
    $('#COD_CLIENTE').html(obj.COD_CLIENTE);
    $('#EMAIL').html(obj.EMAIL);
    $('#CEDULA').html(obj.CEDULA);
    $('#NUM_TELEFONO1').html(obj.NUM_TELEFONO1);
    $('#NUM_TELEFONO2').html(obj.NUM_TELEFONO2);
    $('#NUM_FAX').html(obj.NUM_FAX);
    $('#DIRECCION_ENVIO').html(obj.DIRECCION_ENVIO);
    $('#FREC_ESTADO').html(obj.FREC_ESTADO);
    $('#frec option:contains(' + $('#FREC_ESTADO').html(obj.FREC_ESTADO)["0"].innerText + ')').prop({selected: true});
    }
  });
});
</script>

<?php
  echo '<input type="hidden" id="username" value="'.$_SESSION['username'].'">';
  echo "<script>console.log( 'Debug Objects: " .$_SESSION['username']. "' );</script>";
?>

</html>
