<!DOCTYPE html>

<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="utf-8">
  <meta name="description" content="Proyecto DAW IES San Clemente. Claustro de Profesores.">
  <meta name="author" content="Jose Luis Rego Rodríguez">
  <link rel="icon" href="../../favicon.ico">
  <link rel="stylesheet" type="text/css" href="/ProyectoDawClaustro/css/ClaustroiNet.css">
  <title>ClaustroiNet</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="/ProyectoDawClaustro/librerias/libsExternas/css/bootstrap.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="/ProyectoDawClaustro/librerias/libsExternas/css/bootstrap-theme.min.css">
  <!-- Normalize -->
  <link rel="stylesheet" href="/ProyectoDawClaustro/librerias/libsExternas/css/normalize.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="/ProyectoDawClaustro/librerias/libsExternas/css/bootstrap-select.min.css">
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
<script type="text/javascript" src="/ProyectoDawClaustro/librerias/libsExternas/js/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="/ProyectoDawClaustro/librerias/libsExternas/js/bootstrap.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="/ProyectoDawClaustro/librerias/libsExternas/js/bootstrap-select.min.js"></script>
<!-- Libreria para imprimir -->
<script type="text/javascript" src="ProyectoDawClaustro/librerias/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="/ProyectoDawClaustro/js/scripts.js"></script>

</html>