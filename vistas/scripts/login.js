var showmssge=$("#errorLog");
//Cuando se haga submit al formulario 
$("#LoginForm").on('submit', function(e)
{
	e.preventDefault();
	//capturamos datos de los inputs
	logina=$("#logina").val();
	clavea=$("#clavea").val();
	$.post("../ajax/usuario.php?op=login",
		{"logina":logina,"clavea":clavea},
			//alamcenamos el fetch el datos
			function(data)
			{
				if (data!="null")
				{
					$(location).attr("href", "categoria.php");						
				}else
				{
					showmssge.show();
					$("#clavea").val('');
				}
	});
})
