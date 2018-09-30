var tabla;
function init() {
    listar();
    mostrarform(false);
    $("#formulario").on("submit",function(e){
        guardaryeditar(e);
    } )
    //MOstrar los permisos
    $.post("../ajax/usuario.php?op=permisos&id=", function (r) {
        $("#permisos").html(r);
    });
    $("#imagenmuestra").hide();
}
function limpiar(){
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#cargo").val(""); 
    $("#login").val();
    $("#clave").val("");
    $("#imagenmuestra").attr("src","");
    $("#idusuario").val("");

}
function mostrarform(flag){
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        //ocultar boton agregar al mostrar el form
        $("#btnagregar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
function cancelarform(){
    limpiar();
    mostrarform(false);
}
//Mostrar las categorias
function listar(){
    tabla=$('#tbllistado').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons:[
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax":{
            url: "../ajax/usuario.php?op=listar",
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLenght": 5, //paginacion
        "order":[[0,"desc"]]
    }).DataTable();
}
//funcion para guardar y editar
function guardaryeditar(e){
    e.preventDefault();
    $('#btnGuardar').prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            bootbox.alert(datos);
            mostrarform(false),
                tabla.ajax.reload();
        }
    });
    limpiar();
}

//Mostrar usuario x ID
function mostrar(idusuario) {
    $.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario}, function(data,status)
    {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento);
        $("#num_documento").val(data.num_documento);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#cargo").val(data.cargo);
        $("#login").val(data.login);
        $("#clave").val(data.clave);
        $("#direccion").val(data.direccion);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src", "../files/usuarios/"+data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idusuario").val(data.idusuario);
    });
    $.post("../ajax/usuario.php?op=permisos&id="+idusuario, function (r) {
        $("#permisos").html(r);
    });
}

//Desactivar usuario
function desactivar(idusuario){
    //Caja de confirmacion tipo bootbox
    bootbox.confirm("¿Esta seguro de desactivar el usuario", function(result){
        if(result){
            $.post("../ajax/usuario.php?op=desactivar", {idusuario : idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Activar usuario
function activar(idusuario){
    bootbox.confirm("¿Esta seguro de activar el usuario", function(result){
        if(result){
            $.post("../ajax/usuario.php?op=activar", {idusuario : idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
init();