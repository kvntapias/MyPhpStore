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

                        <h1 class="box-title">Permiso
                            <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <th>Nombre</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <th>Nombre</th>
                            </tfoot>
                        </table>
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
<script src="scripts/permiso.js" type="text/javascript"></script>
<?php 
  }
  //liberamos el buffer
  ob_end_flush();
?>
