<?php $today= date('Y-m-d');?>
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
		<title>Couchinn</title>
	</head>

	<body>

		<?php include("navbar.php"); ?>
		<div class="container">
			<?php if (isset($_GET['msg'])) { ?>
				<div id="alert" role="alert" class="col-md-offset-2 col-md-8 alert <?php echo($_GET['class']) ?>">
					<?php echo($_GET['msg']); ?>
				</div>
			<?php } ?>
			<form class="form-horizontal" name="hacersePremium" method="post" onsubmit="return valNumTarjeta()" action="consultas/alta_premium.php">
				<h1 align="center">Ventajas de ser Premium</h1>
        <p align="center">Al hacerse premium sus couch podran ser listados usando la foto principal de dicho couch, el importe actual es de $ARS 90 por año. </p><br>
        <p align="center">A continuacion podra ingresar los datos de su tarjeta para realizar su pago y transformarse en usuario Premium instantaneamente.</p><br>
        <hr>
        <div class="form-group">
          <span class="text-muted"><em><span style="color:red;">*</span> Estos campos son requeridos</em></span>
        </div> 
        <h3>Tipo de Tarjeta<span style="color:red;">*</span></h3>
				<input type='radio' name='tipoTarjeta' value="Visa" checked> Visa
				<input type='radio' name='tipoTarjeta' value="Mastercard"> Mastercard 
				<input type='radio' name='tipoTarjeta' value="American Express"> American Express  
              
              <div class="form-group">
                 <label class="control-label" for="nroTarjeta">Numero Tarjeta<span style="color:red;">*</span></label>
                  <input type="text" name="nroTarjeta" class="form-control" id="nroTarjeta" onkeypress="return isNumberKey(event)" maxlength="16" placeholder="1234111112341111" aria-describedby="helpBlock-nroTarjeta" required>
                  <span id="glyphicon-nroTarjeta" aria-hidden="true"></span>
                  <span id="helpBlock-nroTarjeta" class="help-block"></span>
              </div>
              <div class="form-group">
                  <label class="control-label" for="fechaCaducidad">Fecha de Caducidad<span style="color:red;">*</span></label>
                  <input type="date" name="fechaCaducidad" class="form-control" id="fechaCaducidad" placeholder="Fecha de Caducidad" min="<?php echo $today ?>" max="2030-01-01"  aria-describedby="helpBlock-fNac" required>
                  <span id="glyphicon-fNac" aria-hidden="true"></span>
                  <span id="helpBlock-fNac" class="help-block"></span>
              </div>
              <div class="form-group">
                 <label class="control-label" for="codSeguridad">Codigo de seguridad<span style="color:red;">*</span></label>
                  <input type="text" name="codSeguridad" class="form-control" id="codSeguridad" onkeypress="return isNumberKey(event)" maxlength="3" placeholder="123" aria-describedby="helpBlock-codSeguridad" required>
                  <span id="glyphicon-codSeguridad" aria-hidden="true"></span>
                  <span id="helpBlock-codSeguridad" class="help-block"></span>
              </div>
              <div class="form-group">
                  <label class="control-label" for="titular">Tituar<span style="color:red;">*</span></label>
                  <input type="text" name="titular" class="form-control" id="titular" placeholder="Juan Perez" onkeypress="return isLetterKey(event)" maxlength="65" aria-describedby="helpBlock-titular" required>
                  <span id="glyphicon-titular" aria-hidden="true"></span>
                  <span id="helpBlock-titular" class="help-block"></span>
              </div>
              <div class="form-group">
                  <label class="control-label" for="direccion">Direccion<span style="color:red;">*</span></label>
                  <input type="text" name="direccion" class="form-control" id="direccion" placeholder="60 e 1 y 2" maxlength="65" aria-describedby="helpBlock-direccion" required>
                  <span id="glyphicon-direccion" aria-hidden="true"></span>
                  <span id="helpBlock-direccion" class="help-block"></span>
              </div>
              <div class="form-group">
                  <label class="control-label" for="ciudad">Ciudad<span style="color:red;">*</span></label>
                  <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="La Plata" onkeypress="return isLetterKey(event)" maxlength="40" aria-describedby="helpBlock-ciudad" required>
                  <span id="glyphicon-ciudad" aria-hidden="true"></span>
                  <span id="helpBlock-ciudad" class="help-block"></span>
              </div>
              <div class="form-group">
                  <label class="control-label" for="provincia">Provincia<span style="color:red;">*</span></label>
                  <input type="text" name="provincia" class="form-control" id="provincia" placeholder="Buenos Aires" onkeypress="return isLetterKey(event)" maxlength="40" aria-describedby="helpBlock-provincia" required>
                  <span id="glyphicon-provincia" aria-hidden="true"></span>
                  <span id="helpBlock-provincia" class="help-block"></span>
              </div>
              <div class="form-group">
                 <label class="control-label" for="codPostal">Codigo Postal<span style="color:red;">*</span></label>
                  <input type="text" name="codPostal" class="form-control" id="codPostal" onkeypress="return isNumberKey(event)" maxlength="4" placeholder="1234" aria-describedby="helpBlock-codPostal" required>
                  <span id="glyphicon-codPostal" aria-hidden="true"></span>
                  <span id="helpBlock-codPostal" class="help-block"></span>
              </div>
              <div class="form-group">
                 <label class="control-label" for="importe">Importe en pesos: </label>
                  <input type="text" name="importe" class="form-control" id="importe" placeholder="90" aria-describedby="helpBlock-importe" disabled>
                  <span id="glyphicon-importe" aria-hidden="true"></span>
                  <span id="helpBlock-importe" class="help-block"></span>
              </div>

              <div class="form-group">
                  <button type="submit" name = "hacersePremium" class="btn btn-primary">Pagar</button>
                  <a class="btn btn-primary" href="index.php">Cancelar</a>
              </div>
          </form>
		</div>
	</body>

</html>
	<?php
	//si no esta loggueado redirige al usuario al index y le manda por get el mensaje correspondiente y setea al error como un warning
} else {
	header("Location: index.php?msg=Debe estar logueado para ver esta pagina&&class=alert-warning");
}?>