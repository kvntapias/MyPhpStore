<?php

//Conexion a la BD
require "../config/conexion.php";

Class Usuario
{
    public function __construct()
    {
    }

    //insertar usuario
    public function insertar(
            $nombre, $tipo_documento, $num_documento, $direccion, $telefono,
            $email, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "INSERT INTO  usuario (nombre, tipo_documento,
        num_documento, direccion, telefono, email,cargo,login,
        clave,imagen, condicion)
				VALUES 
		('$nombre','$tipo_documento','$num_documento','$direccion',
		'$telefono','$email','$cargo','$login','$clave','$imagen', '1')";
        //return ejecutarConsulta($sql);
        $idusuarionew=ejecutarConsulta_retornarID($sql);
        $num_elementos=0;
        $sw=true;
        while ($num_elementos < count($permisos)){
            $sql_detalle= "INSERT INTO usuario_permiso
            (idusuario, idpermiso) values ('$idusuarionew',
            '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos+1;
        }
        return $sw;
    }
    //metodo para editar usuarios
    public function editar($idusuario,
    $nombre, $tipo_documento, $num_documento, $direccion, $telefono,
                           $email, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "UPDATE usuario SET nombre ='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento', direccion='$direccion', telefono='$telefono', email='$email', cargo='$cargo',
        login='$login', clave='$clave', imagen='$imagen' where idusuario='$idusuario'";
        //Reasignar permisos
        $sqldel = "DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
        ejecutarConsulta($sqldel);
        $num_elementos=0;
        $sw=true;
        while ($num_elementos < count($permisos)){
            $sql_detalle= "INSERT INTO usuario_permiso
            (idusuario, idpermiso) values ('$idusuario',
            '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos+1;
        }
        return ejecutarConsulta($sql);
        return $sw;
    }

    //Desactivar usuario
    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='0' where idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //activar usuario
    public function activar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='1' where idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //mostrar datos de un registro a modificar
    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";
        return ejecutarConsultaSimplefila($sql);
    }

    //listar los registros
    public function listar()
    {
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }
    //Listar los permisos
    public function listarMarcados($idusuario){
        $sql="SELECT *FROM usuario_permiso WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }
    //Funcion verificar acceso al sistema
    public function verificar($login, $clave){
        $sql="SELECT 
        idusuario,
         nombre,
        tipo_documento, 
        num_documento,
        telefono,
        email,
        cargo,
        imagen,
        login 
        FROM usuario WHERE login='$login' AND clave='$clave' AND condicion='1'";
        return ejecutarConsulta($sql);
    }
}
?>