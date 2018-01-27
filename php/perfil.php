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

 <body onLoad="getDatos()">

 <div class="mainWrap">

 <a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder"></i>Menu</a>

    <nav>
    <ul class="menu">
   <li><a href="../index.php"><i class="icon-home"></i>INICIO</a>
   </li>
  <li><a  href="perfil.php"><i class="icon-user"></i>PEFIL</a></li>
  <li><a  href="historial.php"><i class="icon-list-ul"></i>HISTORIAL DE TRANSACCIONES</a></li>
  <li><a  href="ayuda.php"><i class="icon-envelope-alt"></i>AYUDA</a></li>
  <li><a  href="#" onclick="DoLogout()"><i class="icon-off"></i>CERRAR SESIÓN</a></li>
  </ul>
  </nav>
 </div><!--end mainWrap-->
 <script>
   //funcion que muestra una confirm box para
   //verificar si se desea cerrar sesion.
   function DoLogout(){
     console.log("cerrar sesión");
     //Ingresamos un mensaje a mostrar
      var mensaje = confirm("¿Desea cerrar sesión?");
      //Detectamos si el usuario acepto el mensaje
      if (mensaje) {
      window.location.replace("metodos/logout.php");
      }
      //Detectamos si el usuario denegó el mensaje
      else {
      window.location.replace("perfil.php");
   }
 }

 </script>

 <table class="table">
    <tr>
      <td align="center">
        <div class="well">
           <ul class="nav nav-tabs">
             <li class="active"><h1 href="#home" data-toggle="tab" >Perfil</h1></li>
           </ul>
           <div id="myTabContent" class="tab-content">
             <div class="tab-pane active in" id="home">
               <form id="tab">
                   <label>Código de Cliente</label>
                   <input type="text" value="123" class="input-xlarge" readonly>
                   <td><em id="person_cod"></em></td>
                   <br></br>
                   <label>Nombre</label>
                   <input type="text" value="ERICK CORDERO" class="input-xlarge" readonly>
                   <td><em id="person_name"></em></td>
                   <br></br>
                   <label>Cédula</label>
                   <input type="text" value="207220864" class="input-xlarge" readonly>
                   <td><em id="person_ced"></em></td>
                   <br></br>
                   <label>Teléfono</label>
                   <input type="text" value="24430139" class="input-xlarge" readonly>
                   <td><em id="person_num1"></em></td>
                   <br></br>
                   <label>Teléfono2</label>
                   <input type="text" value="87022315" class="input-xlarge" readonly>
                   <td><em id="person_num2"></em></td>
                   <br></br>
                   <label>FAX</label>
                   <input type="text" value="" class="input-xlarge" readonly>
                   <td><em id="person_fax"></em></td>
                   <br></br>
                   <label>Email</label>
                   <input type="text" value="eguicoro2@gmail.com" class="input-xlarge" readonly>
                   <td><em id="person_email"></em></td>
                   <br></br>
                   <label>Dirección de Envio</label>
                   <textarea value="Smith" rows="3" class="input-xlarge" readonly>Guadalupe, Alajuela
                   </textarea>
                   <td><em id="person_dir"></em></td>
                   <br></br>
                   <label>Frecuencia de envio de estado de cuenta</label>
                   <select name="DropDownTimezone" id="DropDownTimezone" class="input-xlarge">
                     <option value="Mensual">Mensual</option>
                     <option value="Semanal">Semanal</option>
                     <option value="Cada 2 semanas">Cada 2 semanas</option>
                     <option value="Cada 2 meses">Cada 2 meses</option>
                   </select>
                 	<div>
               	    <button class="btn btn-primary">Actualizar</button>
               	</div>
               </form>
             </div>
           </div>
         </div>
      </td>
    </tr>
 </table>

</body>

<?php
  echo '<input type="hidden" id="username" value="'.$_SESSION['username'].'">';
  echo "<script>console.log( 'Debug Objects: " .$_SESSION['username']. "' );</script>";
?>

</html>
