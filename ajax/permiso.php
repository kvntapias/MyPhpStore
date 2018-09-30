<?php
require_once "../modelos/Permiso.php";
$permiso = new Permiso();
$idcategoria=isset($_POST
    ["idcategoria"])?limpiarCadena($_POST["idcategoria"]):"";
$nombre=isset($_POST
    ["nombre"])?limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST
    ["descripcion"])?limpiarCadena($_POST["descripcion"]):"";
//evaluar los valores para realizar peticion ajax
switch ($_GET["op"]) {
    case 'listar':
        $rspta=$permiso->listar();
        //declarar array
        $data = array();
        while ($reg=$rspta->fetch_object()) {
            $data[]=array(
                "0"=>$reg->nombre
            );
        }
        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);

        echo json_encode($results);
        break;
}
?>
