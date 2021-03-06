<?php
session_start();
if( isset($_SESSION['sesion_usuario']) ){
?>

    <!DOCTYPE html>
    <html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="default.css" rel="stylesheet"><link rel="icon" href="img/logo.png">
        <script src="js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/altaValidaciones.js"></script>
        <title> Couchinn </title>

    </head>
    
    
    <?php 
        include("navbar.php");
        include("conectarBD.php");
        $query="SELECT * FROM tipo WHERE nombre_tipo='".$_POST["nomTipoAModificar"]."'";
        $result=mysqli_query($conexion,$query);
        $row=mysqli_fetch_array($result);

    ?>
    
    <body>
    <div class="container">
        <?php if (isset($_GET['msg'])) { ?>
            <div id="alert" role="alert" class="col-md-offset-2 col-md-8 alert <?php echo($_GET['class']) ?>">
                <?php echo($_GET['msg'])?>
            </div>
        <?php } ?>
        <form class="form-horizontal" name="nomTipo" method="post" onsubmit="return valTipoHospedaje()" action="consultas/modificar_tipo_hospedaje.php">
            <div class="form-group">
                <label class="control-label" for="nomTipo">Nombre</label>
                <input type="hidden" name="idTipo" value="<?php echo($row['id_tipo']) ?>">
                <input type="text" name="nomTipo" class="form-control" id="nomTipo" onkeypress="return isLetterKey(event)" maxlength="30" placeholder="Ej: Casa, Departamento, etc" aria-describedby="helpBlock-nomTipo" value="<?php echo($row['nombre_tipo'])?>" required>
                <span id="glyphicon-nomTipo" aria-hidden="true"></span>
                <span id="helpBlock-nomTipo" class="help-block"></span>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Aceptar</button>
                <a class="btn btn-primary" href="listado_tipos_hospedajes.php">Cancelar</a>
            </div>
        </form>
    </div>

    </body>

    </html>



<?php
  //si no esta loggueado redirige al usuario al index y le manda por get el mensaje correspondiente y setea al error como un warning
  } else {
    header("Location: index.php?msg=debe estar logueado para ver esta pagina&&class=alert-warning");
}?>