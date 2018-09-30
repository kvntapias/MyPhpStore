<?php  
	require_once "../modelos/Articulo.php";
	
	$articulo = new Articulo();

	$idarticulo=isset($_POST
	["idarticulo"])?limpiarCadena($_POST["idarticulo"]):"";
	$idcategoria=isset($_POST
	["idcategoria"])?limpiarCadena($_POST["idcategoria"]):"";
	$codigo=isset($_POST
	["codigo"])?limpiarCadena($_POST["codigo"]):"";
    $stock=isset($_POST
	["stock"])?limpiarCadena($_POST["stock"]):"";
    $nombre=isset($_POST
    ["nombre"])?limpiarCadena($_POST["nombre"]):"";
    $descripcion=isset($_POST
	["descripcion"])?limpiarCadena($_POST["descripcion"]):"";
    $imagen=isset($_POST
	["imagen"])?limpiarCadena($_POST["imagen"]):"";

	//evaluar los valores para realizar peticion ajax
	switch ($_GET["op"]) {
		case 'guardaryeditar':
            //validar que contenga una imagen
			if
			(!file_exists($_FILES['imagen']['tmp_name'])
				|| !is_uploaded_file($_FILES['imagen']['tmp_name']))
			{
				$imagen = $_POST["imagenactual"];
			} else{
				$ext = explode(".", $_FILES["imagen"]["name"]);
				//valida que sea tipo JPG,JPEG o PNG
				if (
				    $_FILES['imagen']['type'] == "image/jpg"||
                    $_FILES['imagen']['type'] == "image/jpeg" ||
                    $_FILES['imagen']['type'] == "image/png")
				{
					$imagen = round(microtime(true)). '.' . end($ext);
					move_uploaded_file($_FILES ["imagen"]['tmp_name'], "../files/articulos/".$imagen);
				}
			}

			if (empty($idarticulo)) {
				$rspta=$articulo->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
				echo $rspta ? "Articulo registrado" : "Error, no se pudo registrar";
			}
			else{
				$rspta=$articulo->editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
				echo $rspta ? "Articulo Actualizado" : "Articulo no actualizado";
			}
			break;
		case 'desactivar':
			$rspta=$articulo->desactivar($idarticulo);
				echo $rspta ? "Articulo Desactivado" : "Articulo NO Desactivado";
			break;
		case 'activar':
			$rspta=$articulo->activar($idarticulo);
				echo $rspta ? "Articulo Activado" : "Articulo NO Activado";
			break;
		case 'mostrar':
				$rspta=$articulo->mostrar($idarticulo);
				//codifica el resultado usando Json
				echo json_encode($rspta);
			break;
		case 'listar':
				$rspta=$articulo->listar();
				//declarar array
				$data = array();
				while ($reg=$rspta->fetch_object()) {
					$data[]=array(
                        //botones activado y desactivado segun condicion
						"0"=>($reg->condicion)?
                        '<button onclick="mostrar('.$reg->idarticulo.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                        ' <button onclick="desactivar('.$reg->idarticulo.')" class="btn btn-danger"><i class="fa fa-close"></i></button>':
                        //boton activar
                        '<button onclick="mostrar('.$reg->idarticulo.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                        ' <button onclick="activar('.$reg->idarticulo.')" class="btn btn-primary"><i class="fa fa-check"></i></button>',
                        
						"1"=>$reg->nombre,
						"2"=>$reg->categoria,
                        "3"=>$reg->codigo,
                        "4"=>$reg->stock,
                        //mostrar la imagen por la ruta
                        "5"=>"<img src='../files/articulos/".$reg->imagen."' height='40px' width='70px' >",
						"6"=>($reg->condicion)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
						);
				}

				$results = array(
					"sEcho"=>1, //info para el datatable
					"iTotalRecords"=>count($data),
					"iTotalDisplayRecords"=>count($data),
					"aaData"=>$data);

				echo json_encode($results);
			break;
        case "selectCategoria":
            require_once "../modelos/Categoria.php";
            $categoria = new Categoria();
            $rspta = $categoria->select();
            while ($reg = $rspta->fetch_object()){
                echo '<option value='. $reg->idcategoria .'>' . $reg->nombre . '</option>';
            }
            break;
	}
?>