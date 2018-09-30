<?php
require_once "../modelos/Persona.php";
$persona = new Persona();

//todos los elementos del formulario almacenados en variables php
$idpersona=isset($_POST["idpersona"])?limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])?limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])?limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])?limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])?limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])?limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])?limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])?limpiarCadena($_POST["email"]):"";

//evaluar los valores para realizar peticion ajax
switch ($_GET["op"]) {
    
    case 'guardaryeditar':
        if (empty($idpersona)) {
            $rspta=$persona->insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            echo $rspta ? "Persona registrada" : "Persona NO registrada";
        }
        else{
            $rspta=$persona->editar($idpersona,$tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            echo $rspta ? "Persona Actualizada" : "Persona no actualizada";
        }
    break;

    case 'eliminar':
        $rspta=$persona->eliminar($idpersona);
        echo $rspta ? "Persona eliminada" : "Persona no eliminada";
    break;

    case 'mostrar':
        $rspta=$persona->mostrar($idpersona);
        //codifica el resultado usando Json
        echo json_encode($rspta);
    break;

    case 'listarp':
        $rspta=$persona->listarp();
        //declarar array
        $data = array();
        while ($reg=$rspta->fetch_object()) {
            $data[]=array(
                "0"=>'<button onclick="mostrar('.$reg->idpersona.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                    ' <button onclick="eliminar('.$reg->idpersona.')" class="btn btn-danger"><i class="fa fa-trash"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->telefono,
                "5"=>$reg->email
            );
        }

        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);

        echo json_encode($results);
    break;

    case 'listarc':
        $rspta=$persona->listarp();
        //declarar array
        $data = array();
        while ($reg=$rspta->fetch_object()) {
            $data[]=array(
                "0"=>'<button onclick="mostrar('.$reg->idpersona.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                    ' <button onclick="eliminar('.$reg->idpersona.')" class="btn btn-danger"><i class="fa fa-trash"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->telefono,
                "5"=>$reg->email
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
