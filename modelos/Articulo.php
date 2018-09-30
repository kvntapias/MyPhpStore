<?php
	//Conexion a la BD	
	require "../config/conexion.php";
	Class Articulo{
		//Constructor
		public function __construct(){}

		//metodo insertar articulo
		public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen){
				$sql="INSERT INTO  articulo (idcategoria, codigo, nombre, stock, descripcion, imagen, condicion)
				VALUES ('$idcategoria', '$codigo', '$nombre', '$stock', '$descripcion', '$imagen', '1')";
				return ejecutarConsulta($sql);
		}

		//metodo para editar articulo
		public function editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen){
			$sql="UPDATE articulo SET 
			idcategoria ='$idcategoria', 
			codigo='$codigo',
			nombre='$nombre',
			stock='$stock',
			descripcion='$descripcion',
			imagen='$imagen'
			where idarticulo = '$idarticulo'";
			return ejecutarConsulta($sql);
		}
		//Desactivar articulos
		public function desactivar($idarticulo){
			$sql="UPDATE articulo SET condicion='0' where idarticulo='$idarticulo'";
			return ejecutarConsulta($sql);
		}
		//activar articulo
		public function activar($idarticulo){
			$sql="UPDATE articulo SET condicion='1' where idarticulo='$idarticulo'";
			return ejecutarConsulta($sql);
		}
		//mostrar datos de un registro a modificar
		public function mostrar($idarticulo){
			$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
			return ejecutarConsultaSimplefila($sql);
		}
		//listar los registros
		public function listar(){
			$sql = "SELECT 
			a.idarticulo, 
			a.idcategoria,
			 c.nombre as categoria, 
			 a.codigo, 
			 a.nombre, 
			 a.stock, 
			 a.descripcion, 
			 a.imagen, 
			 a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
			return ejecutarConsulta($sql);
		}

	}
?>