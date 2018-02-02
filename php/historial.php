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
         document.cookie = "COD_CLIENTE" + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
         document.cookie = "NOM_CLIENTE" + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
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
                    <br></br>
               	</div>
               </form>
             </div>
           </div>
         </div>
      </td>
    </tr>
 </table>

 <table id="historial" class="odd" style="margin: 0 auto;">
   <tr>
    <th>FECHA</th>
    <th>DOCUMENTO</th>
    <th>SUCURSAL</th>
    <th>DESCRIPCIÓN</th>
    <th>MONTO</th>
    <th>PUNTOS OBTENIDOS</th>
    <th>PUNTOS GASTADOS</th>
    <th>SALDO</th>
    <th>DETALLES</th>
  </tr>
</table>

</body>

<script>
$(document).ready(function () {
  $("#success-alert").hide();
  $.ajax({
    type: "GET",
    url: "metodos/getHistorial.php",
    success: function(data){
    // Obtener la referencia del elemento body
    var body = document.getElementsByTagName("body")[0];

    // Crea un elemento <table> y un elemento <tbody>
    var tabla   = document.getElementById("historial");
    var tblBody = document.createElement("tbody");

    //creamos un array con los titulos de cada linea
    var titulos = ["FECHA", "DOCUMENTO", "SUCURSAL", "ARTICULO", "MONTO", "PUNTOSOBT", "PUNTOSUSA", "PUNTOS", "DETALLES"];

    // Crea las celdas
    for (var i = 0; i < 2; i++) {
      // Crea las hileras de la tabla
      var hilera = document.createElement("tr");

      for (var j = 0; j < 9; j++) {
        // Crea un elemento <td> y un nodo de texto, haz que el nodo de
        // texto sea el contenido de <td>, ubica el elemento <td> al final
        // de la hilera de la table
        var celda = document.createElement("td");
        var id = document.createElement("em");
        id.setAttribute("id", titulos[j]);

        celda.appendChild(id);
        hilera.appendChild(celda);
      }

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
      tblBody.appendChild(hilera);
    }

    // posiciona el <tbody> debajo del elemento <table>
    tabla.appendChild(tblBody);
    // appends <table> into <body>
    body.appendChild(tabla);
    // modifica el atributo "border" de la tabla y lo fija a "2";
    tabla.setAttribute("border", "2");

    //seteamos los valores
    console.log("data: "+data);
    var obj = $.parseJSON(data);
    $('#FECHA').html(obj.FECHA);
    $('#DOCUMENTO').html(obj.DOCUMENTO);
    $('#SUCURSAL').html(obj.SUCURSAL);
    $('#ARTICULO').html(obj.ARTICULO);
    $('#MONTO').html(obj.MONTO);
    $('#PUNTOSOBT').html(obj.PUNTOSOBT);
    $('#PUNTOSUSA').html(obj.PUNTOSUSA);
    $('#PUNTOS').html(obj.PUNTOS);
    $('#PUNTOSTRA').html(obj.PUNTOSTRA);
    }
  });
});
</script>
</html>
