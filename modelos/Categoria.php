<?php

	//Conexion a la BD	
	require "../config/conexion.php";

	Class Categoria{

		public function __construct(){

		}
		//insertar registro
		public function insertar($nombre, $descripcion){
				$sql="INSERT INTO  categoria (nombre, descripcion, condicion)
				VALUES ('$nombre', '$descripcion', '1')";
				return ejecutarConsulta($sql);
		}
		//metodo para editar registros
		public function editar($idcategoria,$nombre, $descripcion){
			$sql="UPDATE categoria SET nombre ='$nombre', descripcion='$descripcion' where idcategoria = '$idcategoria'";
			return ejecutarConsulta($sql);
		}

		//Desactivar categorias
		public function desactivar($idcategoria){
			$sql="UPDATE categoria SET condicion='0' where idcategoria='$idcategoria'";
			return ejecutarConsulta($sql);
		}

		//activar categoria
		public function activar($idcategoria){
			$sql="UPDATE categoria SET condicion='1' where idcategoria='$idcategoria'";
			return ejecutarConsulta($sql);
		}

		//mostrar datos de un registro a modificar
		public function mostrar($idcategoria){
			$sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria'";
			return ejecutarConsultaSimplefila($sql);
		}

		//listar los registros
		public function listar(){
			$sql = "SELECT * FROM categoria";
			return ejecutarConsulta($sql);
		}
        //listar las  categorias activas
        public function select(){
            $sql = "SELECT * FROM categoria where condicion = 1";
            return ejecutarConsulta($sql);
        }

	}	

?>