<?php

//Conexion a la BD
require "../config/conexion.php";

Class Persona{
    public function __construct(){
    }
    //insertar registro de persona
    public function insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email )
    {
        $sql="INSERT INTO  persona (tipo_persona, nombre, tipo_documento,
        num_documento,direccion, telefono, email)
				VALUES ('$tipo_persona', '$nombre',
				 '$tipo_documento','$num_documento','$direccion','$telefono', '$email' )";
        return ejecutarConsulta($sql);
    }
    //metodo para editar persona
    public function editar( $idpersona,$tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email)
    {
        $sql="UPDATE persona SET 
        tipo_persona = '$tipo_persona', nombre='$nombre', tipo_documento='$tipo_documento',
        num_documento='$num_documento',direccion='$direccion', telefono='$telefono', email='$email' 
        where idpersona='$idpersona'
        ";
        return ejecutarConsulta($sql);
    }
    //eliminar persona
    public function eliminar($idpersona){
        $sql="DELETE FROM persona WHERE  idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }
    //mostrar datos de un registro a modificar
    public function mostrar($idpersona){
        $sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsultaSimplefila($sql);
    }
    //listar los proveedor
    public function listarp(){
        $sql = "SELECT * FROM persona where  tipo_persona = 'Proveedor'";
        return ejecutarConsulta($sql);
    }
    //listar los cliente
    public function listarc(){
        $sql = "SELECT * FROM persona where  tipo_persona = 'Ciente'";
        return ejecutarConsulta($sql);
    }
}
?>