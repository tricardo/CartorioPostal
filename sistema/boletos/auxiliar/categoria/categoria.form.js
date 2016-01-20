/**
 * @author caio
 */

function buscaSubCategorias(campoIdCategoria,campoIdSubCategoria){
	 $.getJSON("/aluguel/categoria/listarSubsJSON/" + $("#"+campoIdCategoria).val()
	, function(json){
		$("#"+campoIdSubCategoria).empty();
		$("<option>").attr("value","").text("---").appendTo("#"+campoIdSubCategoria);
		$.each(json,
			function(i, item){
				$("<option>").attr("value", item.id).text(item.nome).appendTo("#"+campoIdSubCategoria);
			});
		$('#'+campoIdSubCategoria).change();
	 });
}
