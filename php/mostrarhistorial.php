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


 <center style="margin: 0 auto;">
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
               	<div>
             	    <button  class="btn btn-primary" onclick="window.location.href='historial.php'">Nueva Consulta</button>
                  <br></br>
             	</div>
             </div>
           </div>
         </div>
      </td>
    </tr>
 </center>

 <!--center>
   <br></br>
   <h3 >Puntos Disponibles:
   <em id="PUNTOSOBTOTALES"></em></h3>
   <h3 >Puntos Bloqueados:
   <em id="PUNTOSTRANTOTALES"></em></h3>
   <br></br>
 </center-->

 <table id="historial" class="odd" style="margin: 0 auto;">
   <tr>
    <th>FECHA</th>
    <th>DOCUMENTO</th>
    <th>COMPAÑIA</th>
    <th>SUCURSAL</th>
    <th>DESCRIPCIÓN</th>
    <th>MONTO</th>
    <th>PUNTOS OBTENIDOS</th>
    <th>PUNTOS GASTADOS</th>
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
    if(data.length<=2){
      alert("No hay compras en las fecha seleccionadas");
      location.href ="historial.php";
    }else{
      var obj = $.parseJSON(data);
      // Obtener la referencia del elemento body
      var body = document.getElementsByTagName("body")[0];
      var center = document.createElement("center");
      body.appendChild(center);

      // Crea un elemento <table> y un elemento <tbody>
      var tabla   = document.getElementById("historial");
      var tblBody = document.createElement("tbody");

      //creamos un array con los titulos de cada linea
      var titulos = ["FECHA", "DOCUMENTO","DES_CIA", "DESCRIPCION", "ARTICULO", "MONTO", "PUNTOSOBT", "PUNTOSTRA", "DETALLES"];

      // Crea las celdas
      for (var i = 0; i < obj.length; i++) {
        // Crea las hileras de la tabla
        var hilera = document.createElement("tr");

        //boton para detalles
        var boton = document.createElement("button");
        boton.innerText = "Detalles";
        for (var j = 0; j < titulos.length; j++) {
          // Crea un elemento <td> y un nodo de texto, haz que el nodo de
          // texto sea el contenido de <td>, ubica el elemento <td> al final
          // de la hilera de la table
          var celda = document.createElement("td");
          var id = document.createElement("em");
          if(j==((titulos.length)-1)){
            var formDetalles = document.createElement("form");
            formDetalles.setAttribute("action","metodos/detalle.php");
            formDetalles.setAttribute("method","post");

            var inputBoton = document.createElement("input");
            inputBoton.setAttribute("type","hidden");
            inputBoton.setAttribute("id",titulos[j]+i);
            inputBoton.setAttribute("name","DETALLES");
            inputBoton.setAttribute("value",i);

            boton.setAttribute("id", titulos[j]+i);
            boton.setAttribute("type","submit");
            formDetalles.appendChild(inputBoton);
            formDetalles.appendChild(boton);
            celda.appendChild(formDetalles);
            hilera.appendChild(celda);
          }else{
            id.setAttribute("id", titulos[j]+i);

            celda.appendChild(id);
            hilera.appendChild(celda);
          }
        }

        // agrega la hilera al final de la tabla (al final del elemento tblbody)
        tblBody.appendChild(hilera);
      }

      // posiciona el <tbody> debajo del elemento <table>
      tabla.appendChild(tblBody);
      // appends <table> into <body>
      center.appendChild(tabla);
      // modifica el atributo "border" de la tabla y lo fija a "2";
      tabla.setAttribute("border", "2");

      //seteamos los valores
      //console.log("data: "+data);
      for(i=0; i<obj.length; i++){
        $('#FECHA'+i).html(obj[i].FECHA);
        $('#DOCUMENTO'+i).html(obj[i].DOCUMENTO);
        $('#DES_CIA'+i).html(obj[i].DES_CIA);
        $('#DESCRIPCION'+i).html(obj[i].DESCRIPCION);
        $('#ARTICULO'+i).html(obj[i].ARTICULO);
        $('#MONTO'+i).html(obj[i].MONTO);
        $('#PUNTOSOBT'+i).html(obj[i].PUNTOSOBT);
        $('#PUNTOSTRA'+i).html(obj[i].PUNTOSTRA);
      }

      //form para envair a Imprimir
      var form = document.createElement("form");
      form.setAttribute("action","metodos/pdf.php");
      form.setAttribute("method","post");
      //boton para imprimir
      var imprimir = document.createElement("button");
      imprimir.innerText = "Imprimir";
      imprimir.setAttribute("align","center");

      //valores de puntos
      var espacio = document.createElement("br");
      //appende de los elementos
      center.appendChild(espacio);
      var PuntosDH = document.createElement("h4");
      var PuntosBH = document.createElement("h4");
      PuntosDH.setAttribute("id","PuntosDH");
      PuntosBH.setAttribute("id","PuntosBH");
      var PuntosD = document.createElement("em");
      var PuntosB = document.createElement("em");
      PuntosD.setAttribute("id","PUNTOSOBTOTALES");
      PuntosB.setAttribute("id","PUNTOSTRANTOTALES");
      center.appendChild(PuntosDH);
      center.appendChild(PuntosBH);
      document.getElementById("PuntosDH").innerHTML= "Puntos Disponibles: ";
      document.getElementById("PuntosBH").innerHTML= "Puntos Bloqueados: ";
      PuntosDH.appendChild(PuntosD);
      PuntosBH.appendChild(PuntosB);

      //asignación de los valores de puntos actuales
      $('#PUNTOSOBTOTALES').html(obj[0].PUNTOSOBTOTALES);
      $('#PUNTOSTRANTOTALES').html(obj[0].PUNTOSTRANTOTALES);

      //br para tener mas espacio
      var espacio2 = document.createElement("br");
      //appende de los elementos
      center.appendChild(espacio2);
      center.appendChild(form);
      form.appendChild(imprimir);


      }
    }
  });
});
</script>
</html>
