<?php  
	require_once "../modelos/Categoria.php";
	$categoria = new Categoria();
	$idcategoria=isset($_POST
	["idcategoria"])?limpiarCadena($_POST["idcategoria"]):"";
	$nombre=isset($_POST
	["nombre"])?limpiarCadena($_POST["nombre"]):"";
	$descripcion=isset($_POST
	["descripcion"])?limpiarCadena($_POST["descripcion"]):"";
	//evaluar los valores para realizar peticion ajax
	switch ($_GET["op"]) {

		case 'guardaryeditar':
			if (empty($idcategoria)) {
				$rspta=$categoria->insertar($nombre, $descripcion);
				echo $rspta ? "Categoria registrada" : "Categoria NO registrada";
			}
			else{
				$rspta=$categoria->editar($idcategoria, $nombre, $descripcion);
				echo $rspta ? "Categoria Actualizada" : "Categoria no actualizada";
			}
			break;

		case 'desactivar':
			$rspta=$categoria->desactivar($idcategoria);
				echo $rspta ? "Categoria Desactivada" : "Categoria NO Desactivada";
			break;

		case 'activar':
			$rspta=$categoria->activar($idcategoria);
				echo $rspta ? "Categoria Activada" : "Categoria NO Activada";
			break;

		case 'mostrar':
				$rspta=$categoria->mostrar($idcategoria);
				//codifica el resultado usando Json
				echo json_encode($rspta);
			break;

		case 'listar':
				$rspta=$categoria->listar();
				//declarar array
				$data = array();
				while ($reg=$rspta->fetch_object()) {
					$data[]=array(
						"0"=>($reg->condicion)?'<button onclick="mostrar('.$reg->idcategoria.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                        ' <button onclick="desactivar('.$reg->idcategoria.')" class="btn btn-danger"><i class="fa fa-close"></i></button>':
                        //activar
                        '<button onclick="mostrar('.$reg->idcategoria.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                        ' <button onclick="activar('.$reg->idcategoria.')" class="btn btn-primary"><i class="fa fa-check"></i></button>',
						"1"=>$reg->nombre,
						"2"=>$reg->descripcion,
						"3"=>($reg->condicion)?'<span class="label bg-green">Activa</span>':'<span class="label bg-red">Desctivada</span>'
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
