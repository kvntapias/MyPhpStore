<?php
//almacenamiento en buffer
ob_start();
//iniciamos las sesiones
session_start();
//Si no existe la session
if (!isset($_SESSION["nombre"])) {
  //Lo enviamos al login
    header("location: login.html");
  }else

  {
require 'header.php';

if ($_SESSION['acceso']==1)
{
?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">

                        <h1 class="box-title">Usuario
                            <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <!--celdas-->
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Numero de documento</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Numero de documento</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label> nombre(*):</label>
                                <input type="hidden" name="idusuario" id="idusuario">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Tipo Documento(*):</label>
                                <select class="form-control selectpicker" name="tipo_documento"
                                id="tipo_documento" required>
                                    <option value="DNI">DNI</option
                                    <option value="RUC">RUC</option>
                                    <option value="CEDULA">CEDULA</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Numero de documento(*):</label>
                                <input type="text" class="form-control"
                                name="num_documento" id="num_documento" maxlength="20"
                                placeholder="Numero de Documento" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Direccion:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion"
                                placeholder="Direccion" maxlength="70">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Telefono:</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Email:</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Cargo:</label>
                                <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Cargo" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Login:</label>
                                <input type="text" class="form-control" name="login" id="login" maxlength="256" placeholder="Login">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Clave:</label>
                                <input type="password" class="form-control" name="clave" id="clave" maxlength="256" placeholder="Contraseña">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                             <ul style="list-style: none"; id="permisos">
                                 <label>Permisos </label>
                                 <li></li>
                             </ul>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Imagen</label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" width="150px" height="120px" id="imagenmuestra">
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>

                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arroww-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<?php

} //cerramos if se sesion
else{
  require 'noacceso.php';
}

require 'footer.php';
?>
<!--libreria para generar codigos de barras-->
<script src="scripts/usuario.js" type="text/javascript"></script>
<?php 
  }
  //liberamos el buffer
  ob_end_flush();
?>