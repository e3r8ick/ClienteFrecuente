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
  	header('location: ../index.php?msg=Favor Iniciar Sesion');
  }
  else if ($_COOKIE["COD_CLIENTE"]==null){
    session_destroy();
    header('location: ../index.php?msg=SesionExp');

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
    <tr>
      <td align="center">
        <div class="well">
           <ul class="nav nav-tabs">
            <br></br>
             <li class="active"><h1 href="#home" data-toggle="tab" >Ayuda</h1></li>
              <br></br>
           </ul>
           <div id="myTabContent" class="tab-content">
             <div class="tab-pane active in" id="home">
               <form id="tab" action="metodos/enviarCorreo.php" method="post">
                   <label>Código de Cliente</label>
                   <input name="COD_CLIENTE "id="COD_CLIENTE" type="text" class="input-xlarge" readonly>
                    <br></br>
                   <label>Nombre</label>
                   <input type="text" name="NOMBRE" id="NOMBRE" size="40" class="input-xlarge" readonly>
                    <br></br>
                   <label>Descripción del problema</label>
                   <textarea name="MENSAJE" id="MENSAJE" value="Smith" rows="3" class="input-xlarge">
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

 <script>
 $(document).ready(function () {
   $("#success-alert").hide();
   var usuarioC = document.getElementById("COD_CLIENTE");
   var usuarioN = document.getElementById("NOMBRE");

   //obtenemos el COD_CLIENTE y el NOM_CLIENTE
   usuarioC.setAttribute("value", getCookie("COD_CLIENTE"));
   //hacemos un replace porque el cookie se guarda con un +
   var nom = getCookie("NOM_CLIENTE");
   var cantidad = nom.split("+").length-1;
   for(i = 0 ;i < cantidad; i++){
     nom = nom.replace("+"," ");
   }
   usuarioN.setAttribute("value", nom);
 });

 function getCookie(name) {
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
}
 </script>

</body>
</html>
