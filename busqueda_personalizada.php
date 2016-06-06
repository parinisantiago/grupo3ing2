<?php 
                //Para evitar error de undefined index.
                if (!isset($_GET["titulo"])){ $_GET["titulo"] = '';}
                if (!isset($_GET["ubicacion"])){ $_GET["ubicacion"] = '';}
                if (!isset($_GET["descripcion"])){ $_GET["descripcion"] = '';}
                if (!isset($_GET["capacidad"])){ $_GET["capacidad"] = '';}
                if (!isset($_GET["tipo"])){ $_GET["tipo"] = '';}
                 ?>
<div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">Armá tu búsqueda personalizada!</div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" method="GET" action="index.php">
        <div class="form-group">    
        </div>
        <div class="form-group">
          <label for="contain">Titulo</label>
          <input class="form-control input-sm" type="text" value="<?php echo($_GET["titulo"]) ?>" name="titulo" id="titulo" maxlength="40" placeholder="Cualquiera" />
        </div>
        <div class="form-group">
          <label for="contain">Descripción</label>
          <input class="form-control input-sm" type="text" value="<?php echo($_GET["descripcion"]) ?>" name="descripcion" id="descripcion" maxlength="60" placeholder="Cualquiera" />
        </div>
        <div class="form-group">
          <label for="contain">Tipo</label>
          <select class="form-control input-sm" name="tipo" id="tipo" maxlength="25">
              
              <?php if ($_GET["tipo"] == ''){ ?>
                    <option selected>Cualquiera</option>

              <?php } else { ?>
                        <option hidden selected><?php echo($_GET["tipo"]) ?></option>
                        <option>Cualquiera</option>
                      <?php }?>
              <?php 
                  include("conectarBD.php");
                  $queryDropdownTipos = "SELECT nombre_tipo FROM tipo";
                  $resultadoDropdownTipos = mysqli_query($conexion, $queryDropdownTipos);
                  while ($row = mysqli_fetch_array($resultadoDropdownTipos)) { 
              ?>
                    <option><?php echo($row["nombre_tipo"]); ?></option>
              <?php } ?>
              
          </select>
        </div>
        <div class="form-group">
          <label for="contain">Ubicación</label>
          <input class="form-control input-sm" type="text"  value="<?php echo($_GET["ubicacion"]) ?>" name="ubicacion" id="ubicacion" maxlength="70" placeholder="Cualquiera"/>
        </div>
        <div class="form-group">
          <label for="contain">Capacidad</label>
          <input class="form-control input-sm" type="text"  value="<?php echo($_GET["capacidad"]) ?>" name="capacidad" id="capacidad" onkeypress="return isNumberKey(event)" maxlength="2" placeholder="Cualquiera"/>
        </div>
        
        <button type="submit" class="btn btn-primary btn-md center-block"><span class="glyphicon glyphicon-search" aria-hidden="true"> Buscar</span></button>
      </form>
      </div>
    </div>
</div>