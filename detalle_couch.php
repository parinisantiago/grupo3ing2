<?php

include("conectarBD.php");

session_start(); 
$query= "SELECT * FROM couch INNER JOIN tipo ON (couch.id_tipo = tipo.id_tipo) INNER JOIN usuario ON (couch.id_usuario = usuario.id_usuario) WHERE (couch.id_couch ='".$_GET["id"]."' AND ((couch.eliminado_couch = 1) OR (couch.despublicado = 1)))";
$resultado= mysqli_query($conexion, $query);
$esEliminadoODespublicado = false;
if (mysqli_num_rows($resultado) == 1)
{
    $esEliminadoODespublicado = true;
}
if (isset($_SESSION["anonimo"]) && !isset($_SESSION["admin"])){ //!isset($_SESSION["admin"]) forma rebuscada de verificar que "anonimo"
    $_SESSION["id_usuario"] = -1;                               //esta en false (se lo setea a false en logueo_usuario.php)
}

$query= "SELECT * FROM couch INNER JOIN tipo ON (couch.id_tipo = tipo.id_tipo) INNER JOIN usuario ON (couch.id_usuario = usuario.id_usuario) WHERE (couch.id_couch ='".$_GET["id"]."' AND couch.eliminado_couch = 0)";
$resultado= mysqli_query($conexion, $query);
$row = mysqli_fetch_array($resultado);
$first= true; //control para las imagenes
$esDuenio = false;
if ($_SESSION["id_usuario"] == $row["id_usuario"])
{
    $esDuenio = true;
}
$query= "SELECT * FROM couch INNER JOIN tipo ON (couch.id_tipo = tipo.id_tipo) INNER JOIN usuario ON (couch.id_usuario = usuario.id_usuario) WHERE (couch.id_couch ='".$_GET["id"]."')";
$resultado= mysqli_query($conexion, $query);
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
    <script src="js/puntajesValidaciones.js"></script>
    <title> Couchinn </title>
</head>

<body>

<?php include("navbar.php"); ?>
<div class="container">
                    <?php if (isset($_GET['msg'])) { ?>
<div id="alert" role="alert" class="col-md-offset-2 col-md-8 alert <?php echo($_GET["class"]); ?>">
                        <?php echo($_GET['msg']); ?>
                    </div>
                <?php } ?>
</div>
<div class="container">
    <?php while ( $couch = mysqli_fetch_array($resultado)) {
        //busca las fotos del couch para agregarlas al carousel
        $query_foto="SELECT ruta FROM foto WHERE id_couch='".$_GET["id"]."'";
        $resultado_foto=mysqli_query($conexion, $query_foto);
        $cant_fotos=mysqli_num_rows($resultado_foto);
        ?>



                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">

                                        <?php for($i = 0; $i < $cant_fotos; $i++){ ?>

                                            <li data-target="#myCarousel" data-slide-to=<?php echo($i); if($i == 0){ echo(" class=active");} ?>></li>

                                        <?php } ?>

                                    </ol>

                                    <?php if ($cant_fotos != 0){ ?>
                                        <!-- Wrapper for slides class="img-responsive center-block"-->
                                        <div class="carousel-inner" role="listbox">
                                            <?php while ( $foto = mysqli_fetch_array($resultado_foto)) {
                                                if( $first){ $first=false;?>
                                                    <div class="item active">
                                                        <img  src="<?php echo($foto["ruta"]);?>" >
                                                    </div>
                                                <?php } else {?>
                                                    <div class="item">
                                                        <img  src="<?php echo($foto["ruta"]);?>" >
                                                    </div>
                                                <?php }
                                            } ?>

                                        </div>
                                    <?php } else { ?>
                                        <div class="carousel-inner" role="listbox">
                                            <div class="item active">
                                                <img  src=<?php echo("img/logo.png");?> >
                                            </div>
                                        </div>
                                    <?php }        ?>
                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <p class="h2 col-md-offset-4"> Datos del Couch
                                <?php if ($couch["eliminado_couch"])
                                    {
                                        echo(" <font color='red'> (ELIMINADO)</font>");
                                    }
                                    else if ($couch["despublicado"])
                                    {
                                        echo(" <font color='orange'> (DESPUBLICADO)</font>");
                                    } ?></p>

                                <!-- infromacion del couch -->

                                <div class="col-md-offset-2 col-md-6 inf_couch">
                                    <d1 class="dl-horizontal">
                                        <dt> Título: </dt>
                                        <dd> <?php echo($couch["titulo"]) ?></dd>
                                        <dt> Descripción: </dt>
                                        <dd> <?php echo($couch["descripcion"]) ?></dd>
                                        <dt> Tipo:</dt>
                                        <dd> <?php echo($couch["nombre_tipo"]) ?></dd>
                                        <dt> Ubicación: </dt>
                                        <dd> <?php echo($couch["ubicacion"]) ?></dd>
                                        <dt> Dirección: </dt>
                                        <dd> <?php echo($couch["direccion"]) ?></dd>
                                        <dt> Capacidad: </dt>
                                        <dd> <?php echo($couch["capacidad"]) ?></dd>

                                 <!-- puntaje promedio -->
                                    <?php
                                        $promedioQuery= "SELECT AVG(puntaje) AS promedio FROM puntoscouch WHERE id_couch ='". $_GET['id'] ."'";
                                        $promedioConsulta= mysqli_query($conexion, $promedioQuery);
                                        while ($promedio = mysqli_fetch_array($promedioConsulta)) {

                                           //controla que haya puntajes
                                            if($promedio['promedio'] == NULL){ ?>

                                           <dt>Puntaje promedio: </dt>
                                           <dd> 0 </dd>

                                     <?php       } else {
                                    ?>
                                          <dt> <a href=<?php echo("listadoPuntajes.php?idCouch=".$_GET['id']);?>> Puntaje promedio: </a> </dt>
                                          <dd> <?php echo(substr($promedio['promedio'], 0, 4)); ?></dd>
                                       <?php }}
                                    ?>
                                    </d1>
                                </div>

                                <p class="h2 col-md-offset-4"> Datos del usuario</p>

                                <!-- informacion del usuario, ni idea porque no se lista igual que el couch -->

                                <div class="col-md-offset-2 col-md-6 inf_couch">
                                    <d1 class="dl-horizontal">
                                        <dt> Nombre: </dt>
                                        <dd> <?php echo($couch["nombre"]) ?> <?php echo($couch["apellido"]);?></dd>
                                        <?php
                                            $queryDatosExtras = "SELECT estado FROM reserva WHERE id_usuario = '".$_SESSION['id_usuario']."' AND estado = 'Aceptada' AND id_couch = '".$_GET['id']."'";
                                            $resultadoDatosExtras = mysqli_query($conexion, $queryDatosExtras);
                                            if (mysqli_num_rows($resultadoDatosExtras) > 0)
                                            {
                                                ?>
                                                <dt> Email: </dt>
                                                <dd> <?php echo($couch["email"]) ?></dd>
                                                <dt> Telefono: </dt>
                                                <dd> <?php echo($couch["telefono"])?></dd>
                                            <?php
                                            }
                                        ?>
                                    </d1>
                                </div>

                                    <br><br>
                            <?php   }    ?>
                                
                                <?php if($esDuenio){  ?>
                                    
                                    <!-- Inicio de aceptar o rechazar reservas -->
                                    <div class="col-md-7">
                                        <div class="panel panel-primary">

                                            <div class="panel-heading">
                                                Listado de reservas en espera por este couch.
                                            </div>
                                            <?php
                                            include_once("conectarBD.php");
                                            //Se fija cuales de las reservas estan  pasadas de fecha para ponerlas como vencidas.
                                            $queryReservasVencidas = "UPDATE reserva SET estado = 'Vencida' WHERE ((finicio < CURDATE()) AND (estado='En espera'))";
                                            mysqli_query($conexion, $queryReservasVencidas);
                                            $queryReservasFinalizadas = "UPDATE reserva SET estado = 'Finalizada' WHERE ((ffin < CURDATE()) AND (estado='Aceptada'))";
                                            mysqli_query($conexion, $queryReservasFinalizadas);
                                            //Ltsta todas las reservas que están en espera de ser aceptadas o rechazadas
                                            $queryReservasEnEspera = "SELECT id_reserva, usuario.nombre, usuario.apellido, id_usuario, id_couch, estado,DATE_FORMAT(finicio, '%d-%m-%y') AS finicio, DATE_FORMAT(ffin, '%d-%m-%y') AS ffin FROM reserva NATURAL JOIN usuario WHERE ((id_couch = '".$_GET["id"]."') AND (estado = 'En espera'))";
                                            $resultadoReservasEnEspera = mysqli_query($conexion, $queryReservasEnEspera);
                                            ?>
                                            <form name="formularioReservasEnEspera" action="consultas/aceptar_rechazar_reserva.php" method="POST">
                                                <?php    while ($rowReservas = mysqli_fetch_array($resultadoReservasEnEspera)) {
                                                    ?>


                                                    <input type="hidden" name="idCouch" class="form-control" id="idCouch" value="<?php echo($_GET["id"])?>">


                                                    <div class="form-group" id="">
                            <?php  echo("Solicitud de ".$rowReservas["nombre"]." ".$rowReservas["apellido"]." del ".$rowReservas["finicio"]." al ".$rowReservas["ffin"]);?>
                            <button type="submit" class="btn btn-sm btn-primary glyphicon glyphicon-ok" name = "aceptar" id="aceptar.<?php  echo($rowReservas["id_reserva"]); ?>" onclick="return confirm('¿Esta seguro de que desea aceptar la reserva?')" value="<?php  echo($rowReservas["id_reserva"]); ?>" class="btn btn-primary"> Aceptar</button>
                            <button type="submit" class="btn btn-sm btn-danger glyphicon glyphicon-remove" name = "rechazar" id = "rechazar.<?php  echo($rowReservas["id_reserva"]); ?>" onclick="return confirm('¿Esta seguro de que desea rechazar la reserva?')" value="<?php  echo($rowReservas["id_reserva"]); ?>" class="btn btn-primary"> Rechazar</button>
                            <hr>    
                        </div> 
                            <?php   }
                            ?>
                            
                            
                            </form>

                </div>

            </div>
            <!-- Fin de aceptar o rechazar reservas -->
            <?php }  ?>
            


    <!--Listado de reservas realizadas -->
    <?php if (!$esEliminadoODespublicado){
        $queryRervasFin="SELECT id_puntajeCouch, id_reserva, DATE_FORMAT(finicio, '%d-%m-%y') AS finicio, DATE_FORMAT(ffin,'%d-%m-%y') AS ffin FROM reserva WHERE id_couch='".$_GET['id']."' AND estado='Finalizada' AND id_usuario='". $_SESSION['id_usuario'] ."'";
        $consultaReservasFin= mysqli_query($conexion, $queryRervasFin);
        while( $reservasFin = mysqli_fetch_array($consultaReservasFin)) {
            if (!isset($reservasFin['id_puntajeCouch'])) {
                ?>
                    <br>
                <div class="panel panel-primary puntajeCouch">
                    
                    <div class="panel-heading">
                        <p>Puntúe su estadía del dia: <?php echo($reservasFin['finicio']); ?> hasta el
                            dia: <?php echo($reservasFin['ffin']); ?> </p>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="consultas/alta_puntajeCouch.php" class="form-horizontal">
                            <div class="form-group">
                                <label for="puntReser" class="control-label">Puntua tu estadía: </label>
                                <input type="range" min="1" max="5" name="puntReser" id="puntReser"
                                       onchange="changeValue('puntReser' , 'puntReserShow')">
                                <input type="text" id="puntReserShow" value = "3" size="1" maxlength="1" min="1" max="5"
                                       onkeypress="return is1to5(event)"
                                       onchange="changeValue('puntReserShow', 'puntReser')" required>
                            </div>
                            <div class="form-group">
                                <label for="puntReserCont" class="control-label">Deje su comentario sobre la
                                    estadía: </label>
                                <textarea class="form-control" rows="5" cols="50" maxlength="250" name="puntReserCont"
                                          id="puntReserCont"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary">Puntuar</button>
                            </div>
                            <input type="hidden" name="id_couch" value=<?php echo($_GET['id']); ?>>
                            <input type="hidden" name="id_reserva" value=<?php echo($reservasFin['id_reserva']); ?>>
                            <input type="hidden" name="id_usuario" value=<?php echo($_SESSION['id_usuario']); ?>>
                        </form>
                    </div>
                </div>

            <?php }
        }}
    ?><?php if (!$esEliminadoODespublicado){?>
     <div class="col-md-12">
            <!-- Lista de preguntas y respuestas -->
    <h3 align="center"> Preguntas de los usuarios: </h3>

    <?php

        $preguntasQuery="SELECT * FROM pregunta INNER JOIN usuario ON pregunta.id_usuariopregunta = usuario.id_usuario WHERE id_couch='" .$_GET['id'] ."'";
        $consulta= mysqli_query($conexion, $preguntasQuery);
        if (mysqli_num_rows($consulta) == 0) { ?>
            <div id="alert" role="alert" class="col-md-offset-2 col-md-8 alert alert-warning">
                No se han realizado preguntas en este couch
            </div>
        <?php     }
        while($preguntas = mysqli_fetch_array($consulta)){
    ?>
            <ul class="list-group lista-preguntas">

        <li class="list-group-item">
           <!-- seccion de pregunta -->
            <div>
                
            <p class="text-left"> <?php echo("El usuario ".$preguntas['nombre']." ".$preguntas['apellido']." pregunta:");?> </p>
            <?php echo($preguntas['contenidopregunta']) ?>


            </div>

           <!-- seccion de respuesta -->
            <div class="text-center respuesta">

                <?php if($preguntas['contenidorespuesta'] != null){
                    echo("<hr>");
                    echo("<p class="."text-left"."> Respuesta: </p>");
                    echo($preguntas['contenidorespuesta']);
                } else if($esDuenio){ ?>
                <hr>
                <a class="btn btn-primary collapsed" role="button" data-toggle="collapse" aria-expanded="false"  aria-controls=<?php echo("#collapsedResp" . $preguntas['id_pregunta']);?> href=<?php echo("#collapsedResp" . $preguntas['id_pregunta']);?>>Responder</a>

                <!-- Collapsed form para la respuesta -->

                <div class="collapse" aria-expanded="false" id=<?php echo("collapsedResp" . $preguntas['id_pregunta']);?>  style="height: 0;">
                    <div class="well">
                        <form class="form-horizontal" method="GET" action="consultas/altaRespuesta.php" name=<?php echo("formResp" . $preguntas['id_pregunta']);?> >
                            <div class="form-group">
                                <label class="control-label" for=<?php echo("respCouch" . $preguntas['id_pregunta']);?> >Respuesta: </label>
                                <textarea class="form-control" rows="5" cols="50" maxlength="500" name="respCouch"  id=<?php echo("respCouch" . $preguntas['id_pregunta']);?>  required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary"> Enviar </button>
                            </div>
                            <input type="hidden" name="idCouch" value=<?php echo($_GET['id']); ?>>
                            <input type="hidden" name="idPregunta" value=<?php echo($preguntas['id_pregunta']); ?>>
                        </form>
                    </div>
                </div>

             <?php   }  ?>

            </div>

        </li>
    </ul>

    <?php }} ?>


    <!-- Text area para hacer preguntas en caso de que no sea el dueño del Couch -->

    <?php if(!$esDuenio && isset($_SESSION['admin']) && $_SESSION['admin'] != true && isset($_SESSION['sesion_usuario']) && $_SESSION['sesion_usuario'] == true && !$esEliminadoODespublicado){

        ?>



        <form name="form-preguntas" class="form-horizontal" method="GET" action="consultas/altaPregunta.php">
            <div class="form-group">
                <label class="control-label" for="preguntaCouch">Haga su pregunta al dueño: </label>
                <textarea class="form-control" rows="5" cols="50" maxlength="500" name="preguntaCouch" id="preguntaCouch" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary">Preguntar</button>
            </div>
            <input type="hidden" name="idCouch" value=<?php echo($_GET['id']); ?>>
            <input type="hidden" name="idUsuario" value=<?php echo($_SESSION['id_usuario']); ?>>
        </form>

    <?php } ?>
    <?php   if (isset($_SESSION["admin"]) && !$esDuenio && !$_SESSION["admin"] && !$esEliminadoODespublicado) {  ?>
                <?php include("reservar_couch.php");?>
                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modalReservarCouch"> Reservar</a>

            <?php   }  ?>
    <div class = "container"></div> 
    <a class="btn btn-primary" href="index.php">Volver</a>
    
    <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){

        $query= "SELECT * FROM couch INNER JOIN tipo ON (couch.id_tipo = tipo.id_tipo) INNER JOIN usuario ON (couch.id_usuario = usuario.id_usuario) WHERE couch.id_couch ='".$_GET["id"]."'";
        $resultado= mysqli_query($conexion, $query);
        $couch = mysqli_fetch_array($resultado);
        if ($couch['eliminado_couch'] == 0){?>

            <form name="formEliminarCouch" class="form-horizontal" method="POST" action="radioButton_listado_couch.php">
                <div class="form-group">
                    <button type="submit" name = "Eliminar" id = "Eliminar" class="btn btn-warning">Eliminar</button>
                </div>
                <input type="hidden" name="idUser" id = "idUser" value=<?php echo($couch['id_usuario']); ?>>
                <input type="hidden" name="esAdmin" id = "esAdmin" value="true">
                <input type="hidden" name="vieneDelDetalle" id = "vieneDelDetalle" value="true">
                <input type="hidden" name="couch" id = "couch" value=<?php echo($couch['id_couch']); ?>>
            </form>

    <?php }} ?>
</div>
</body>

</html>



