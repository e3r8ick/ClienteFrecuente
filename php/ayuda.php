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
  <li><a  href="../index.php"><i class="icon-off" onclick="DoLogout();"></i>CERRAR SESIÓN</a></li>
  <script>
    //funcion que muestra una confirm box para
    //verificar si se desea cerrar sesion.
    function DoLogout(){
      //var salir = confirm('¿Desea cerrar sesion?');
      var salir =
        swal({
          //se pide confirmacion para cerrar la sesion.
            title: 'Desea cerrar sesion?',
            //text: "Desea cerrar sesion?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
        }).then(function () {
          //Si la confirmacion devuelve falso o null, no se realiza el logout
          if (salir) {
            //en caso de ser true, se realiza el window.location.replace(), donde por medio de PHP
            // se destruye la sesion y se redirecciona a la pagina de login.
            window.location.replace("../metodos/logout.php");
          }
        });
    }

    //funcion que devuelve al index, para evitar tener que agregar un anchor
    function index(){
      window.location.replace("index.php");
    }

    //Esta funcion se encarga de agregar dinamicamente los indicadores de que
    //hay elementos de submenu en el menu.
    function addIndicator(){
      //se obtienen los elementos que tengan submenu
      var subs = document.getElementsByClassName('nav-menu__submenu');
      //se recorren todos
      for (var i = 0 ; i < subs.length; i++) {
        //se obtiene el padre
        var padre = subs[i].parentNode;
        //se ingresa en el anchor y se concatena el indicador.
        var anchor = padre.getElementsByClassName('nav-menu__anchor');
        anchor[0].innerHTML = "| " + anchor[0].innerHTML + ' |';
      }
    }
  </script>
  </ul>
  </nav>
 </div><!--end mainWrap-->


 <table>
    <tr>
      <td align="center">
        <div class="well">
           <ul class="nav nav-tabs">
             <li class="active"><h1 href="#home" data-toggle="tab" >Ayuda</h1></li>
           </ul>
           <div id="myTabContent" class="tab-content">
             <div class="tab-pane active in" id="home">
               <form id="tab">
                   <label>Código de Cliente</label>
                   <input type="text" value="123" class="input-xlarge" readonly>
                   <br></br>
                   <label>Nombre</label>
                   <input type="text" value="ERICK CORDERO" class="input-xlarge" readonly>
                   <br></br>
                   <label>Descripción del problema</label>
                   <textarea value="Smith" rows="3" class="input-xlarge">
                   </textarea>
                   <br></br>
                 	<div>
               	    <button class="btn btn-primary">Enviar</button>
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
