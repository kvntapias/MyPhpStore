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

if ($_SESSION['almacen']==1)
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

                        <h1 class="box-title">Articulo
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
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> nombre(*):</label>
                                <input type="hidden" name="idarticulo" id="idarticulo">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Categoria(*):</label>
                                <select id="idcategoria" name="idcategoria"  required>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label> Stock(*):</label>
                                <input type="number" class="form-control" name="stock" id="stock" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Descripcion</label>
                                <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Imagen</label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" width="150px" height="120px" id="imagenmuestra">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Codigo</label>
                                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="codigo de barras">
                                <button class="btn btn-success" type="button" onclick="generarbarcode()"> Generar </button>
                                <button class="btn btn-info" type="button" onclick="imprimir()"> Imprimir </button>
                                <div id="print">
                                    <svg id="barcode"></svg>
                                </div>
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
<script  src="../public/js/JsBarcode.all.min.js" type="text/javascript"></script>
<script src="../public/js/jquery.PrintArea.js" type="text/javascript"></script>
<script src="scripts/articulo.js" type="text/javascript"></script>
<?php 
  }
  //liberamos el buffer
  ob_end_flush();
?>