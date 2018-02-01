<?php 
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Proyecto DAW IES San Clemente. Claustro de Profesores.">
  <meta name="author" content="Jose Luis Rego Rodríguez">
  <link rel="icon" href="../../favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/ClaustroiNet.css">
  <title>ClaustroiNet</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
</head>

<body>

  <div class="jumbotron" align="center">
    <div id="titulo" class="container" align="center">
      <h3>Aplicación de Configuración de Claustros.</h3>
    </div>
    <h2 id="reset">ClaustroiNet</h2>
  </div>
  <div align="center" id="contenidoAjax"> </div>
  <div class="container">
    <div class="row" align="center">
      <div class="col-md-6">
        <button id="btnNuevo" class="btn btn-default" type="button">Nuevo Claustro</button>
      </div>
      <div class="col-md-6">
        <button id="btnHistorico" class="btn btn-default" type="button">Histórico de Claustros</button>
      </div>
      <!-- <div class="col-md-4">
        <button id="btnProfes" class="btn btn-default" type="button">Actualizar Profesores</button>
      </div> -->
    </div>
    <br>

    <div class="row" id="nuevo">
      <div>
        <div class="" id="niz">
          <form class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-2 control-label">Título Claustro:</label>
              <div class="col-sm-4">
                <input name="titulo" type="text" id="tituloClaustro" size="50" required placeholder="Escriba un título para el Claustro."
                />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Día:</label>
              <div class="col-sm-4">
                <input name="fecha" type="date" id="fecha" required value="<?php echo date('Y-m-d'); ?>" />
              </div>
              <label class="col-sm-2 control-label">Curso:</label>
              <div class="col-sm-4">
                <input name="curso" type="text" id="curso" required placeholder="Curso: 2015-2016" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Hora Inicio:</label>
              <div class="col-sm-4">
                <input type="time" name="fecha" id="horaInicio" required value="<?php echo date('H:i'); ?>">
              </div>
              <label class="col-sm-2 control-label">Hora Fin:</label>
              <div class="col-sm-4">
                <input type="time" name="fecha" id="horaFin" required value="<?php echo date('H:i'); ?>">
              </div>
            </div>
          </form>
          <br>
          <label>Orden del día:</label>
          <textarea id="orden" class="form-control" rows="4" required placeholder="Escriba la orden del día."></textarea>
          <label>Observaciones:</label>
          <textarea id="observacion" class="form-control" rows="4" placeholder="Alguna observación?"></textarea>
        </div>
        <div id="selectProfesores">
          <select class="selectpicker" required multiple id="selecProfe" data-live-search="true" title="Seleccione Profesor">
          </select>
        </div>
        <div id="seleccion"></div>
      </div>
      <div>
        <button id="crearClaustro" class=".col-md-3 .col-md-offset-3 center-block">Crear Claustro</button>
      </div>
    </div>

    <br>
    <div class="row" id="historico">
      <div class="col-xs-6 col-md-4" id="hiz">
        <label>Listado de Claustros:</label>
        <div id="historicoClaustros"></div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-8" id="hdr">
        <label>Datos del Claustro:</label>
        <div class="jumbotron" id="datosClaustroHistorico"></div>
      </div>
      <div id="display_dialog"></div>
      <div class="col-md-3 center-block">
        <button type="button" id="imprimir" class="btn btn-success center-block">Imprimir!</button>
      </div>
      <div class="col-md-3 center-block">
        <button type="button" id="editar" class="btn btn-primary center-block">Editar!</button>
      </div>
      <div class="col-md-3 center-block">
        <button type="button" id="borrar" class="btn btn-danger center-block">Borrar!</button>
      </div>
      <div class="col-md-3 center-block">
        <button type="button" id="guardar" class="btn btn-info center-block">Guardar!</button>
      </div>
    </div>
    <hr>

    <footer>
      <p>&copy; 2016 regorodrijl.</p>
    </footer>
  </div>
</body>
<!-- script  -->
<!-- jQuery CDN versión 2.2.4 ya que bootstrap no sopeorta la 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
  crossorigin="anonymous"></script>
<script>
  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date(); a = s.createElement(o),
      m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
  })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

  ga('create', 'UA-86031054-1', 'auto');
  ga('send', 'pageview');
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<!-- Libreria para imprimir -->
<script type="text/javascript" src="librerias/js/jquery.PrintArea.js"></script>
<script src="/ProyectoDawClaustro/js/scripts.js"></script>

</html>