<LINK REL=StyleSheet HREF="../css/login.css" TYPE="text/css">

<form class="login" action="metodos/register.php" method="post">
    <h1 class="login-title">Cliente Frecuente</h1>
    <input type="text" id="username" name="username" class="login-input" placeholder="Cod Cliente" autofocus required="true">
    <input type="password" id="password" name="password" class="login-input" placeholder="Contraseña" required="true">
    <input type="password" id="passwordC" name="passwordC" class="login-input" placeholder="Confirmar Contraseña" required="true">

    <?php
      //se incluyen los archivos necesarios.
      require_once ('conexion/conexion.php');
      require_once ('conexion/metodos.php');
      echo "<script>console.log( 'Debug Objects: " . "sirve1". "' );</script>";
    ?>

    <input type="submit" value="Registrar" class="login-button">
  </form>
