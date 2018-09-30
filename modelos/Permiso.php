<?php

//Conexion a la BD
require "../config/conexion.php";

Class Permiso{

    public function __construct(){
    }
    //listar los registros
    public function listar(){
        $sql = "SELECT * FROM permiso";
        return ejecutarConsulta($sql);
    }
}
?>