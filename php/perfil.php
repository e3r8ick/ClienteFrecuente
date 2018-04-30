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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript" ></script>
    <script src="../js/perfil.js" type="text/javascript"></script>

</head>

 <body>

 <div class="mainWrap">

 <a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder"></i>Menu</a>

    <nav>
    <ul class="menu">
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
 <div class="container">
   <div class="jumbotron" >
     <br>
         <h2 id="perfil" style="text-align:center;">PERFIL</h2>
         <br></br>
   <table class="table" style="margin: 0 auto;">
       <tr>
         <td>Código Cliente: </td>
         <td><em id="COD_CLIENTE"></em></td>
       </tr>
       <tr>
         <td>Nombre de Usuario: </td>
         <td><em id="NOM_CLIENTE"></em></td>
       </tr>
       <tr>
         <td>Puntos Activos: </td>
         <td><em id="PUNTOSOBT"></em></td>
       </tr>
       <tr>
         <td>Puntos Bloqueados: </td>
         <td><em id="PUNTOSTRA"></em></td>
       </tr>
       <tr>
         <td>Cédula: </td>
         <td><em id="CEDULA"></em></td>
       </tr>
       <tr>
         <td>Número de Teléfono 1: </td>
         <td><em id="NUM_TELEFONO1"></em></td>
       </tr>
       <tr>
         <td>Número de Teléfono 2: </td>
         <td><em id="NUM_TELEFONO2"></em></td>
       </tr>
       <tr>
         <td>Número de Fax: </td>
         <td><em id="NUM_FAX"></em></td>
       </tr>
       <tr>
         <td>Email: </td>
         <td><em id="EMAIL"></em></td>
       </tr>
       <tr>
         <td>Dirección de Envio: </td>
         <td><em id="DIRECCION_ENVIO"></em></td>
       </tr>
       <tr>
         <td>Frecuencia de envio de estados de cuenta: </td>
         <td><em id="FREC_ESTADO"></em></td>
       </tr>
     </table>
   </div>
 </div>

 <div class="container" style="text-align:center;">
   <form role="form" action="metodos/update.php" method="post">
     <br></br>
     <h4>Cambiar frecuencia de envio</h4>
     <select id="frec" name="frec">
        <option value="Semanal">Semanal</option>
        <option value="Quincenal">Quincenal</option>
        <option value="Mensual">Mensual</option>
        <option value="Bimestral">Bimestral</option>
    </select>
    <br></br>
    <button type="submit">Actualizar</button>
  </form>
  <br></br>
  <br></br>
  <br></br>
  <br></br>
 </div>

</body>

<script>
$(document).ready(function () {
  $("#success-alert").hide();
  $.ajax({
    type: "GET",
    url: "metodos/getDatos.php",
    success: function(data){
    //console.log("data: "+data);
    var obj = $.parseJSON(data);
    $('#NOM_CLIENTE').html(obj.NOM_CLIENTE);
    $('#COD_CLIENTE').html(obj.COD_CLIENTE);
    $('#PUNTOSOBT').html(obj.PUNTOSOBT);
    $('#PUNTOSTRA').html(obj.PUNTOSTRA);
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

  function setCookie(name, value, days) {
      var d = new Date;
      d.setTime(d.getTime() + 24*60*60*1000*days);
      document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
  }
</script>
</html>
