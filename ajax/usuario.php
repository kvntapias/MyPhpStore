<?php
session_start();
require_once "../modelos/Usuario.php";
//Se crea el objeto tipo usuario de la clase Usuario
$usuario = new Usuario();
//Captura los datos del formulario y los almacena en variables php
$idusuario=isset($_POST
    ["idusuario"])?limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST
    ["nombre"])?limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST
    ["tipo_documento"])?limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST
    ["num_documento"])?limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST
    ["direccion"])?limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST
    ["telefono"])?limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST
    ["email"])?limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST
    ["cargo"])?limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST
    ["login"])?limpiarCadena($_POST["login"]):"";
$clave=isset($_POST
    ["clave"])?limpiarCadena($_POST["clave"]):"";
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
                //tipos de imagen permitidas
                $_FILES['imagen']['type'] == "image/jpg"||
                $_FILES['imagen']['type'] == "image/jpeg" ||
                $_FILES['imagen']['type'] == "image/png")
            {
                $imagen = round(microtime(true)). '.' . end($ext);
                //almacena la imagen en el directorio asignado
                move_uploaded_file($_FILES ["imagen"]['tmp_name'], "../files/usuarios/".$imagen);
            }
        }
        //Hash SHA256 para encriptacion de la contraseña
        $clavehash=hash("SHA256", $clave);
        if (empty($idusuario)) {
            $rspta=$usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono,
                $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario registrado" : "no se pudo registrar todos los datos del usuario";
        }
        else{
            $rspta=$usuario->editar(
                $idusuario,
                $nombre, $tipo_documento, $num_documento, $direccion, $telefono,
                $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario Actualizado" : "Usuario no actualizado";
        }
    break;

    case 'desactivar':
        $rspta=$usuario->desactivar($idusuario);
        echo $rspta ? "Usuario Desactivado" : "Usuario NO Desactivado";
    break;

    case 'activar':
        $rspta=$usuario->activar($idusuario);
        echo $rspta ? "Usuario Activado" : "Usuario NO Activado";
    break;
    case 'mostrar':
        $rspta=$usuario->mostrar($idusuario);
        //codifica el resultado usando Json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$usuario->listar();
        //declarar array
        $data = array();
        while ($reg=$rspta->fetch_object()) {
            $data[]=array(
                //botones activado y desactivado segun condicion
                "0"=>($reg->condicion)?
                    '<button onclick="mostrar('.$reg->idusuario.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                    ' <button onclick="desactivar('.$reg->idusuario.')" class="btn btn-danger"><i class="fa fa-close"></i></button>':
                    //boton activar
                    '<button onclick="mostrar('.$reg->idusuario.')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>'.
                    ' <button onclick="activar('.$reg->idusuario.')" class="btn btn-primary"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->direccion,
                "5"=>$reg->telefono,
                "6"=>$reg->email,
                "7"=>$reg->login,
                //mostrar la imagen por la ruta
                "8"=>"<img src='../files/usuarios/".$reg->imagen."' height='40px' width='70px' >",
                "9"=>($reg->condicion)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
            );
        }

        $results = array(
            "sEcho"=>1, //info para el datatable
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);

        echo json_encode($results);
    break;

    case 'permisos':
        //obtiene los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso=new Permiso();
        $rspta=$permiso->listar();
        //OBTENER PERMISOS DEL USUARIO ESPECIFICO
        $id=$_GET['id'];
        $marcados = $usuario->listarMarcados($id);
        $valores = array();
        while ($per=$marcados->fetch_object()) {
            array_push($valores, $per->idpermiso);
        }

        /*muestra la lista de permidos en la vista y si estan
        marcados o no*/
        while ($reg=$rspta->fetch_object())
        {
           $sw=in_array($reg->idpermiso,$valores)?'checked':'';
            echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]"  value="'.$reg->idpermiso.'">'.$reg->nombre .'</li>';
        }
        break;

        //LOGIN Y VARIABLES DE SESION (PERMISOS A MODULOS)
        case 'login':
        //capturar datos del formulario
            $logina=$_POST['logina'];
            $clavea=$_POST['clavea'];
        //encriptamos la clave
        $clavehash=hash("SHA256",$clavea);
        //enviamos parametros al metodo login
        $rspta=$usuario->verificar($logina,$clavehash);

        $fetch=$rspta->fetch_object();
        //si la respuesta no es vacia
        if (isset($fetch))
        {
           //creamos las variables de sesión le asignamos
            //lo que nos devuelve el fetch de la BD
            $_SESSION['idusuario']=$fetch->idusuario;
            $_SESSION['nombre']=$fetch->nombre;
            $_SESSION['imagen']=$fetch->imagen;
            $_SESSION['login']=$fetch->login;
            //Obtener permisos del usuario
            $marcados=$usuario->listarMarcados($fetch->idusuario);
            //declaramos array 
            $valores=array();
            //almacenamos los permisos en el array
            while ($per=$marcados->fetch_object()) {
                array_push($valores, $per->idpermiso);
            }
            //determinamos los permisos del usuario
            /*si el id del permiso se encuenrtra dentro del array valores creamos
            la variable de session correspondiente 
            si existe la variable de sesion sera = 1 sino 
            estará en 0, inactiva
            */
            in_array(1, $valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
            in_array(2, $valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
            in_array(3, $valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
            in_array(4, $valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
            in_array(5, $valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
            in_array(6, $valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
            in_array(7, $valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;
        }
        echo json_encode($fetch);
        break;

        //LOGOUT
        case 'salir':
            //Limpiamos variablesd e sesion
            session_unset();
            //destruimos la sesion
            session_destroy();
            //redireccion al index
            header("location: ../index.php");
            break;
}
?>