var tabla;
function init() {
    listar();
    mostrarform(false);
    $("#formulario").on("submit",function(e){
        guardaryeditar(e);
    } )

    //carga los items al select del form
    $.post("../ajax/articulo.php?op=selectCategoria", function (r) {
        $("#idcategoria").html(r);
    })

    $("#imagenmuestra").hide();
}
function limpiar(){
    $("#coodigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#stock").val("");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val("");
    $("#print").hide();
    $("#idarticulo").val("");
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
            url: "../ajax/articulo.php?op=listar",
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "iDisplayLenght": 5, //paginacion por pagina
        "order":[[0,"desc"]]


    }).DataTable();
}
//funcion para guardar y editar
function guardaryeditar(e){
    e.preventDefault();
    $('#btnGuardar').prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
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

function mostrar(idarticulo) {
    $.post("../ajax/articulo.php?op=mostrar",{idarticulo : idarticulo}, function(data,status)
    {
        data = JSON.parse(data);
        mostrarform(true);
        $("#idcategoria").val(data.idcategoria);
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#imagenmuestra").show();
        //se envia la ruta a la etiqueta img para previsualizarla
        $("#imagenmuestra").attr("src", "../files/articulos/"+data.imagen);
        $("#imagenactual").val(data.imagen);
        
        $("#idarticulo").val(data.idarticulo);
        generarbarcode();
    })
}
//Desactivar articulo
function desactivar(idarticulo){
    //Caja de confirmacion tipo bootbox
    bootbox.confirm("¿Esta seguro de desactivar el Articulo", function(result){
        if(result){
            $.post("../ajax/articulo.php?op=desactivar", {idarticulo : idarticulo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Activar articulo
function activar(idarticulo){
    bootbox.confirm("¿Esta seguro de activar el Articulo", function(result){
        if(result){
            $.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();

            });
        }
    })
}
//funcion para generar codigo de barras
function generarbarcode(){
    codigo=$("#codigo").val();
    JsBarcode("#barcode", codigo);
    $("#print").show();
}
//funcion para imprimir el barcode
function imprimir(){
    $("#print").printArea();
}
init();